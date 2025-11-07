const DB_NAME='financebuddy-idb', DB_VER=1, STORE='txqueue';
function openDB(){
  return new Promise((res,rej)=>{
    const r=indexedDB.open(DB_NAME,DB_VER);
    r.onupgradeneeded = ()=>{ const db=r.result; if(!db.objectStoreNames.contains(STORE)) db.createObjectStore(STORE,{keyPath:'localId',autoIncrement:true});};
    r.onsuccess=()=>res(r.result);
    r.onerror=()=>rej(r.error);
  });
}
async function addLocal(tx){ const db=await openDB(); const t=db.transaction(STORE,'readwrite'); t.objectStore(STORE).add(tx); return new Promise(s=>t.oncomplete=s); }
async function getAllLocal(){ const db=await openDB(); return new Promise((res,rej)=>{ const r=db.transaction(STORE).objectStore(STORE).getAll(); r.onsuccess=()=>res(r.result); r.onerror=()=>rej(r.error); }); }
async function clearLocal(){ const db=await openDB(); const t=db.transaction(STORE,'readwrite'); t.objectStore(STORE).clear(); return new Promise(s=>t.oncomplete=s); }
