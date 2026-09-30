(function () {
  'use strict';

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var desktop = window.matchMedia('(min-width: 992px)');
  var clamp01 = function (v) { return Math.min(1, Math.max(0, v)); };
  var ease = function (t) { return t * t * (3 - 2 * t); };
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

  /* ---- story: intro stays pinned while the details panels slide up over it ---- */
  var story = document.querySelector('[data-story]');
  var storyUpdate = function () {};
  var tabsThumb = function () {};
  if (story) {
    var pin = story.firstElementChild;
    var left = story.querySelector('[data-left]');
    var right = story.querySelector('[data-right]');
    var scrollBox = story.querySelector('[data-scroll]');
    var tabsWrap = story.querySelector('[data-tabs]');
    var tabBtns = Array.prototype.slice.call(tabsWrap.querySelectorAll('[data-tab]'));
    var lists = Array.prototype.slice.call(story.querySelectorAll('[data-list]'));
    var captions = Array.prototype.slice.call(story.querySelectorAll('[data-caption]'));
    tabsThumb = pillThumb(tabsWrap);
    var activeTab = 'highlights';

    var activeList = function () { return story.querySelector('[data-list="' + activeTab + '"]'); };
    var extra = function (list) { return Math.max(0, list.offsetHeight - scrollBox.clientHeight); };

    storyUpdate = function () {
      if (!desktop.matches) {
        story.style.height = '';
        left.style.transform = right.style.transform = '';
        lists.forEach(function (l) { l.style.transform = ''; });
        return;
      }
      var pinH = pin.offsetHeight;
      var maxAll = Math.max.apply(null, lists.map(extra));
      story.style.height = Math.round(pinH * 2.4 + maxAll) + 'px';

      var stick = parseFloat(getComputedStyle(pin).top) || 0;
      var y = stick - story.getBoundingClientRect().top;             // px scrolled inside the section
      var a = ease(clamp01((y - pinH * 0.15) / (pinH * 0.55)));     // left image panel rises
      var b = ease(clamp01((y - pinH * 0.40) / (pinH * 0.55)));     // right panel rises
      left.style.transform = 'translate3d(0,' + ((1 - a) * 100).toFixed(2) + '%,0)';
      right.style.transform = 'translate3d(0,' + ((1 - b) * 100).toFixed(2) + '%,0)';

      var list = activeList();
      var s = clamp01((y - pinH * 1.2) / (extra(list) || 1));         // then the list scrolls inside the panel
      lists.forEach(function (l) { l.style.transform = l === list ? 'translate3d(0,' + (-s * extra(l)).toFixed(1) + 'px,0)' : ''; });
    };

    var setTab = function (name) {
      activeTab = name;
      tabBtns.forEach(function (t) { t.classList.toggle('is-active', t.getAttribute('data-tab') === name); });
      lists.forEach(function (l) { l.classList.toggle('is-on', l.getAttribute('data-list') === name); });
      captions.forEach(function (c) { c.classList.toggle('is-on', c.getAttribute('data-caption') === name); });
      tabsThumb();
      storyUpdate();
    };
    tabBtns.forEach(function (t) { t.addEventListener('click', function () { setTab(t.getAttribute('data-tab')); }); });
    setTab('highlights');
  }

  /* ---- outdoor spaces: pinned, cards travel sideways with the active card centred ---- */
  var hs = document.querySelector('[data-hscroll]');
  var hsUpdate = function () {};
  if (hs) {
    var hsPin = hs.firstElementChild;
    var track = hs.querySelector('[data-track]');
    var cards = Array.prototype.slice.call(track.children);
    var bars = hs.querySelectorAll('[data-progress] i');
    var hsTitle = hs.querySelector('[data-amen-title]');
    var hsStat = hs.querySelector('[data-amen-stat]');

    hsUpdate = function () {
      var rect = hs.getBoundingClientRect();
      var stick = parseFloat(getComputedStyle(hsPin).top) || 0;
      var scrollable = hs.offsetHeight - hsPin.offsetHeight;
      var p = clamp01((stick - rect.top) / (scrollable || 1));
      var n = cards.length;
      var pos = p * (n - 1);
      var w = cards[0].offsetWidth;
      var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      var x = (hsPin.clientWidth - w) / 2 - pos * (w + gap);
      track.style.transform = 'translate3d(' + x.toFixed(1) + 'px,0,0)';
      cards.forEach(function (c, i) {
        var d = clamp01(Math.abs(i - pos));
        c.style.opacity = (1 - d * 0.5).toFixed(2);
        c.style.transform = 'scale(' + (1 - d * 0.05).toFixed(3) + ')';
      });
      var active = Math.round(pos);
      bars.forEach(function (bar, i) { bar.classList.toggle('is-on', i === active); });
      var fade = (1 - clamp01((p - 0.03) / 0.1)).toFixed(2);
      hsTitle.style.opacity = fade;
      hsStat.style.opacity = fade;
    };
  }

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
  var tick = raf(function () { hdrCheck(); revealCheck(); storyUpdate(); hsUpdate(); mapCheck(); });
  var relayout = function () { plansThumb(); tabsThumb(); tick(); };
  window.addEventListener('scroll', tick, { passive: true });
  window.addEventListener('resize', relayout);
  window.addEventListener('load', relayout);
  if (desktop.addEventListener) desktop.addEventListener('change', relayout);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(relayout);
  relayout();
})();
