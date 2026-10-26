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
// hero slider: auto-rotate, arrow buttons, dots, swipe
const sl=$$('.sl'),tx=$$('.hc .t'),dt=$$('.dots b');let i=0,tm;
function go(n){n=(n+sl.length)%sl.length;[sl,tx,dt].forEach(a=>{a[i].classList.remove('on');a[n].classList.add('on')});i=n}
function auto(){clearInterval(tm);tm=setInterval(()=>go(i+1),6500)}
if(sl.length>1){const hero=$('.hero');auto();
 dt.forEach((d,n)=>d.onclick=()=>{go(n);auto()});
 [['prev','Previous slide',-1,'\u2039'],['next','Next slide',1,'\u203a']].forEach(([c,l,d,t])=>{
  const b=document.createElement('button');b.className='arr '+c;b.setAttribute('aria-label',l);b.textContent=t;
  b.onclick=()=>{go(i+d);auto()};hero.appendChild(b)});
 let x0=null;hero.addEventListener('touchstart',e=>{x0=e.touches[0].clientX},{passive:true});
 hero.addEventListener('touchend',e=>{if(x0===null)return;const dx=e.changedTouches[0].clientX-x0;x0=null;
  if(Math.abs(dx)>50){go(i+(dx<0?1:-1));auto()}});
}
// contact form opens WhatsApp with the typed message
const f=$('#wf');f&&f.addEventListener('submit',e=>{e.preventDefault();const d=new FormData(f);
 open('https://wa.me/'+f.dataset.wa+'?text='+encodeURIComponent('Hello RACO, my name is '+d.get('name')+'. '+d.get('msg')),'_blank')});
})();
