"use strict";
document.addEventListener("DOMContentLoaded", function() {



  //100vh
const setFillHeight = () => {
  const vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', `${vh}px`);
}

window.addEventListener('resize', setFillHeight);
setFillHeight();




//hamburger_menu
$(".hamburger").on("click", function () {
  $(this).toggleClass("js-active");
  $("body").toggleClass("js-fixed");
  $(".header").toggleClass("js-active");
  $(".gnav").toggleClass("js-active");
});
$(".gnav__item a").on("click", function () {
  $("body").removeClass("js-fixed");
  $(".hamburger").removeClass("js-active");
  $(".gnav").removeClass("js-active");
});



//sp_non_hover
$(function () {
  const touch = 'ontouchstart' in document.documentElement || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;

  if (touch) {
    try {
      for (let si = 0; si < document.styleSheets.length; si++) {
        const styleSheet = document.styleSheets[si];
        if (!styleSheet.rules) continue;

        for (let ri = styleSheet.rules.length - 1; ri >= 0; ri--) {
          if (!styleSheet.rules[ri].selectorText) continue;

          if (styleSheet.rules[ri].selectorText.match(':hover')) {
            styleSheet.deleteRule(ri);
          }
        }
      }
    } catch (ex) {}
  }
});



// header表示onoff
let beforePos = 0;

function scrollAnime() {
  const elemTop = 500;
  const scroll = window.pageYOffset || document.documentElement.scrollTop;

  if (scroll === beforePos) {
    // 何もしない
  } else if (elemTop > scroll || scroll - beforePos < 0) {
    document.querySelector('.header').classList.remove('up');
    document.querySelector('.header').classList.add('down');
  } else {
    document.querySelector('.header').classList.remove('down');
    document.querySelector('.header').classList.add('up');
  }

  beforePos = scroll;
}

window.addEventListener('scroll', scrollAnime);
window.addEventListener('load', scrollAnime);


// 各フェードイン設定
const fadeElements = gsap.utils.toArray(".js-fadeUp, .js-fadeRight, .js-fadeLeft");

fadeElements.forEach(element => {
  // 初期設定
  let fromVars = {opacity: 0};

  // クラス名に応じて異なる動きを設定
  if (element.classList.contains("js-fadeUp")) {
    fromVars.y = 40; // 上からフェードイン
  } else if (element.classList.contains("js-fadeRight")) {
    fromVars.x = -100; // 右からフェードイン
  } else if (element.classList.contains("js-fadeLeft")) {
    fromVars.x = 100; // 左からフェードイン
  }

  // アニメーションの設定
  gsap.fromTo(
    element,
    fromVars,
    {
      x: 0,
      y: 0,
      duration: 0.5,
      opacity: 1,
      scrollTrigger: {
        trigger: element,
        start: "top 80%",
      },
    }
  );
});



// ページ内のスムーススクロール
jQuery('a[href*="#"]').click(function (e) {
  const target = jQuery(this.hash === "" ? "html" : this.hash);
  if (target.length) {
    e.preventDefault();
    const headerHeight = jQuery("header").outerHeight();
    const position = target.offset().top - headerHeight - 20;
    jQuery("html, body").animate({ scrollTop: position }, 500, "swing");

    if (!target.is("html")) {
      // URLにハッシュを含める
      history.pushState(null, '', this.hash);
    }
  }
});

// 別ページ遷移後のスムーススクロール
const urlHash = location.hash;
if (urlHash) {
  const target = jQuery(urlHash);
  if (target.length) {
    // ページトップから開始（ブラウザ差異を考慮して併用）
    history.replaceState(null, '', window.location.pathname);
    jQuery("html,body").stop().scrollTop(0);

    jQuery(window).on("load", function () {
      const headerHeight = jQuery("header").outerHeight();
      const position = target.offset().top - headerHeight - 20;
      jQuery("html, body").animate({ scrollTop: position }, 500, "swing");

      // ハッシュを再設定
      history.replaceState(null, '', window.location.pathname + urlHash);
    });
  }
}



});
