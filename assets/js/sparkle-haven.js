(function () {
  'use strict';

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var desktop = window.matchMedia('(min-width: 992px)');
  var raf = function (fn) {
    var pending = false;
    return function () { if (!pending) { pending = true; requestAnimationFrame(function () { pending = false; fn(); }); } };
  };

  /* ---- scroll reveal (scroll-position based so anchor jumps never leave content hidden) ---- */
  var revealEls = Array.prototype.slice.call(document.querySelectorAll('[data-reveal]'));
  var revealCheck = function () {
    var edge = window.innerHeight * 0.94;
    revealEls = revealEls.filter(function (el) {
      if (el.getBoundingClientRect().top < edge) { el.classList.add('is-in'); return false; }
      return true;
    });
  };
  if (reduce) { revealEls.forEach(function (el) { el.classList.add('is-in'); }); revealEls = []; }

  /* ---- hero video: sound toggle ---- */
  var video = document.querySelector('[data-hero-video]');
  var soundBtn = document.querySelector('[data-hero-sound]');
  if (video) {
    var tryPlay = function () { var p = video.play(); if (p && p.catch) p.catch(function () {}); };
    tryPlay();
    document.addEventListener('visibilitychange', function () { if (!document.hidden) tryPlay(); });
  }
  if (video && soundBtn) {
    soundBtn.addEventListener('click', function () {
      video.muted = !video.muted;
      soundBtn.setAttribute('aria-pressed', video.muted ? 'false' : 'true');
      soundBtn.setAttribute('aria-label', video.muted ? 'Unmute video' : 'Mute video');
      soundBtn.firstElementChild.className = video.muted ? 'fas fa-volume-mute' : 'fas fa-volume-up';
      tryPlay();
    });
  }

  /* ---- pill tabs with a sliding thumb (details tabs + floor tabs) ---- */
  function pillThumb(wrap) {
    var thumb = wrap.querySelector('.sh-pills__thumb, .sh-tabs__thumb');
    return function () {
      var b = wrap.querySelector('button.is-active');
      if (!b || !thumb) return;
      thumb.style.width = b.offsetWidth + 'px';
      thumb.style.transform = 'translateX(' + b.offsetLeft + 'px)';
    };
  }

  /* ---- accordions (FAQ, single-open) ---- */
  document.querySelectorAll('[data-acc]').forEach(function (acc) {
    var btn = acc.querySelector('.sh-acc__btn');
    btn.addEventListener('click', function () {
      var open = !acc.classList.contains('is-open');
      if (open) {
        acc.parentNode.querySelectorAll('.sh-acc.is-open').forEach(function (o) {
          o.classList.remove('is-open');
          o.querySelector('.sh-acc__btn').setAttribute('aria-expanded', 'false');
        });
      }
      acc.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });

  /* ---- floor plans: facing switch + floor pills + arrows ---- */
  var plans = document.querySelector('.sh-plans');
  var plansThumb = function () {};
  if (plans) {
    var facingBtns = plans.querySelectorAll('[data-facing]');
    var pillWrap = plans.querySelector('[data-pills]');
    var floorBtns = Array.prototype.slice.call(pillWrap.querySelectorAll('[data-floor]'));
    plansThumb = pillThumb(pillWrap);
    var facing = facingBtns[0].getAttribute('data-facing');
    var floorIdx = 0;

    var render = function () {
      var floor = floorBtns[floorIdx].getAttribute('data-floor');
      plans.querySelectorAll('.sh-plan').forEach(function (p) {
        p.hidden = p.getAttribute('data-plan') !== facing + '-' + floor;
      });
      facingBtns.forEach(function (b) { b.classList.toggle('is-active', b.getAttribute('data-facing') === facing); });
      floorBtns.forEach(function (b, i) { b.classList.toggle('is-active', i === floorIdx); });
      var facingName = plans.querySelector('[data-facing="' + facing + '"]').textContent;
      plans.querySelector('[data-facing-label]').textContent = facingName;
      plans.querySelector('[data-facing-caption]').textContent = facingName;
      plans.querySelector('[data-floor-label]').textContent = floorBtns[floorIdx].textContent + ' (4 BHK)';
      plansThumb();
    };

    facingBtns.forEach(function (b) {
      b.addEventListener('click', function () { facing = b.getAttribute('data-facing'); render(); });
    });
    floorBtns.forEach(function (b, i) {
      b.addEventListener('click', function () { floorIdx = i; render(); });
    });
    var step = function (d) { floorIdx = (floorIdx + d + floorBtns.length) % floorBtns.length; render(); };
    plans.querySelector('[data-floor-prev]').addEventListener('click', function () { step(-1); });
    plans.querySelector('[data-floor-next]').addEventListener('click', function () { step(1); });
    render();
  }

  /* ---- story: intro, then the Highlights / Specification tabs (normal page scroll, nothing pinned) ---- */
  var story = document.querySelector('[data-story]');
  var tabsThumb = function () {};
  if (story) {
    var tabsWrap = story.querySelector('[data-tabs]');
    var tabBtns = Array.prototype.slice.call(tabsWrap.querySelectorAll('[data-tab]'));
    var lists = Array.prototype.slice.call(story.querySelectorAll('[data-list]'));
    var captions = Array.prototype.slice.call(story.querySelectorAll('[data-caption]'));
    tabsThumb = pillThumb(tabsWrap);

    var setTab = function (name) {
      tabBtns.forEach(function (t) { t.classList.toggle('is-active', t.getAttribute('data-tab') === name); });
      lists.forEach(function (l) { l.classList.toggle('is-on', l.getAttribute('data-list') === name); });
      captions.forEach(function (c) { c.classList.toggle('is-on', c.getAttribute('data-caption') === name); });
      tabsThumb();
    };
    tabBtns.forEach(function (t) { t.addEventListener('click', function () { setTab(t.getAttribute('data-tab')); }); });
    setTab('highlights');
  }

  /* ---- image loading placeholders: shimmer until each image has decoded, then fade it in ---- */
  document.querySelectorAll('.sh-page img[loading]').forEach(function (img) {
    if (img.complete && img.naturalWidth) { img.classList.add('is-loaded'); return; }
    img.addEventListener('load', function () { img.classList.add('is-loaded'); });
    img.addEventListener('error', function () { img.classList.add('is-loaded'); });
  });

  /* ---- location: sidebar glides in; map is veiled until "Interact with map" ---- */
  var stage = document.querySelector('[data-map-stage]');
  var mapCheck = function () {};
  if (stage) {
    var toggle = stage.querySelector('[data-map-toggle]');
    mapCheck = function () {
      if (stage.getBoundingClientRect().top < window.innerHeight * 0.8) stage.classList.add('is-in');
    };
    toggle.addEventListener('click', function () {
      var live = stage.classList.toggle('is-live');
      toggle.textContent = live ? 'Show drive times' : 'Interact with map';
    });
  }

  /* ---- one scroll/resize pipeline ---- */
  var heroEl = document.querySelector('.sh-hero');
  var hdrCheck = function () {
    var past = !heroEl || heroEl.getBoundingClientRect().bottom <= 0;
    document.body.classList.toggle('sh-hdr-hidden', !past);
  };
  var tick = raf(function () { hdrCheck(); revealCheck(); mapCheck(); });
  var relayout = function () { plansThumb(); tabsThumb(); tick(); };
  window.addEventListener('scroll', tick, { passive: true });
  window.addEventListener('resize', relayout);
  window.addEventListener('load', relayout);
  if (desktop.addEventListener) desktop.addEventListener('change', relayout);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(relayout);
  relayout();
})();
