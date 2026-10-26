(()=>{
const $=s=>document.querySelector(s),$$=s=>[...document.querySelectorAll(s)];
// preloader (always clears, even on slow load)
const pre=$('#pre'),t0=Date.now(),hide=()=>pre.classList.add('done');
addEventListener('load',()=>setTimeout(hide,Math.max(0,800-(Date.now()-t0))));setTimeout(hide,5000);
// header
const hd=$('header'),sc=()=>hd.classList.toggle('s',scrollY>40);sc();addEventListener('scroll',sc,{passive:true});
$('.burger').onclick=()=>hd.classList.toggle('open');
$$('nav a').forEach(a=>a.addEventListener('click',()=>hd.classList.remove('open')));
// counters + reveal
function count(el){const v=+el.dataset.count,s=el.dataset.s||'',t=performance.now();
 (function f(n){const p=Math.min((n-t)/1600,1);el.textContent=Math.round(v*(1-Math.pow(1-p,3))).toLocaleString()+s;if(p<1)requestAnimationFrame(f)})(t)}
const io=new IntersectionObserver(es=>es.forEach(e=>{if(!e.isIntersecting)return;
 e.target.classList.add('in');if(e.target.dataset.count)count(e.target);io.unobserve(e.target)}),{threshold:.2});
$$('.rv,[data-count]').forEach(e=>io.observe(e));
// hero slider
const sl=$$('.sl'),tx=$$('.hc .t'),dt=$$('.dots b');let i=0;
function go(n){[sl,tx,dt].forEach(a=>{a[i].classList.remove('on');a[n].classList.add('on')});i=n}
if(sl.length>1){let tm=setInterval(()=>go((i+1)%sl.length),6500);
 dt.forEach((d,n)=>d.onclick=()=>{clearInterval(tm);go(n)})}
// contact form opens WhatsApp with the typed message
const f=$('#wf');f&&f.addEventListener('submit',e=>{e.preventDefault();const d=new FormData(f);
 open('https://wa.me/'+f.dataset.wa+'?text='+encodeURIComponent('Hello RACO, my name is '+d.get('name')+'. '+d.get('msg')),'_blank')});
})();
