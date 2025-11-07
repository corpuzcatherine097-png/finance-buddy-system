document.addEventListener('DOMContentLoaded',()=>{
  const form=document.getElementById('expenseForm');
  if(!form) return;
  form.addEventListener('submit', async e=>{
    e.preventDefault();
    const tx={category:document.getElementById('category').value, amount:parseFloat(document.getElementById('amount').value), note:document.getElementById('note').value, created_at:new Date().toISOString()};
    if(navigator.onLine){
      // try server
      const fd=new FormData(); fd.append('category',tx.category); fd.append('amount',tx.amount); fd.append('note',tx.note);
      try{
        const res=await fetch('/financebuddy/add_expense.php',{method:'POST',body:fd});
        // if success redirect
        location.href='/financebuddy/dashboard.php';
      }catch(err){ await addLocal(Object.assign(tx,{user_id:USER_ID})); alert('Saved offline, will sync.'); location.href='/financebuddy/dashboard.php'; }
    } else {
      await addLocal(Object.assign(tx,{user_id:USER_ID}));
      alert('Saved offline, will sync when online.');
      location.href='/financebuddy/dashboard.php';
    }
  });

  async function trySync(){
    const list = await getAllLocal();
    if(!list || list.length===0) return;
    try{
      const res = await fetch('/financebuddy/api/sync.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({user_id:USER_ID,transactions:list})});
      const j=await res.json();
      if(j.inserted>0){ await clearLocal(); alert('Offline items synced.'); location.reload(); }
    }catch(e){ console.warn('sync failed',e); }
  }
  window.addEventListener('online', trySync);
  if(navigator.onLine) trySync();
});
