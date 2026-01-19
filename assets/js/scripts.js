/**
 * Blog7 Custom Theme Scripts
 */

(function($) {
    'use strict';
    
    // Back to Top 버튼
    function initBackToTop() {
        const backToTop = $('.generate-back-to-top');
        
        if (backToTop.length) {
            const startScroll = parseInt(backToTop.data('start-scroll')) || 300;
            const scrollSpeed = parseInt(backToTop.data('scroll-speed')) || 400;
            
            // 스크롤 이벤트
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > startScroll) {
                    backToTop.addClass('show');
                } else {
                    backToTop.removeClass('show');
                }
            });
            
            // 클릭 이벤트
            backToTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, scrollSpeed);
            });
        }
    }
    
    // 검색 모달
    function initSearchModal() {
        const searchTrigger = $('[data-gpmodal-trigger="gp-search"]');
        const searchModal = $('#gp-search');
        const searchClose = $('[data-gpmodal-close]');
        const searchInput = $('#search-modal-input');
        
        if (searchTrigger.length && searchModal.length) {
            // 열기
            searchTrigger.on('click', function(e) {
                e.preventDefault();
                searchModal.addClass('active');
                $('body').addClass('modal-open');
                setTimeout(function() {
                    searchInput.focus();
                }, 100);
            });
            
            // 닫기
            searchClose.on('click', function(e) {
                if ($(e.target).is(searchClose)) {
                    searchModal.removeClass('active');
                    $('body').removeClass('modal-open');
                }
            });
            
            // ESC 키로 닫기
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && searchModal.hasClass('active')) {
                    searchModal.removeClass('active');
                    $('body').removeClass('modal-open');
                }
            });
        }
    }
    
    // 이미지 레이지 로딩 폴백
    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            // 브라우저가 네이티브 lazy loading을 지원함
            return;
        }
        
        // IntersectionObserver 사용
        if ('IntersectionObserver' in window) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                        }
                        if (img.dataset.srcset) {
                            img.srcset = img.dataset.srcset;
                        }
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            images.forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }
    
    // 외부 링크에 속성 추가
    function initExternalLinks() {
        $('a[href^="http"]').not('[href*="' + window.location.hostname + '"]').each(function() {
            $(this).attr({
                target: '_blank',
                rel: 'noopener noreferrer'
            });
        });
    }
    
    // 스무스 스크롤
    function initSmoothScroll() {
        $('a[href^="#"]').not('[href="#"]').on('click', function(e) {
            const target = $(this.hash);
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 600);
            }
        });
    }
    
    // 포스트 카드 호버 효과
    function initPostHover() {
        $('.post').hover(
            function() {
                $(this).find('img').css('transform', 'scale(1.05)');
            },
            function() {
                $(this).find('img').css('transform', 'scale(1)');
            }
        );
    }
    
    // 접근성 향상
    function initAccessibility() {
        // 포커스 표시
        $('a, button, input, textarea, select').on('focus', function() {
            $(this).addClass('focused');
        }).on('blur', function() {
            $(this).removeClass('focused');
        });
        
        // 키보드 네비게이션
        $(document).on('keydown', function(e) {
            if (e.key === 'Tab') {
                $('body').addClass('using-keyboard');
            }
        });
        
        $(document).on('mousedown', function() {
            $('body').removeClass('using-keyboard');
        });
    }
    
    // 초기화
    $(document).ready(function() {
        initBackToTop();
        initSearchModal();
        initLazyLoading();
        initExternalLinks();
        initSmoothScroll();
        initPostHover();
        initAccessibility();
    });
    
    // 윈도우 리사이즈
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // 리사이즈 후 실행할 코드
        }, 250);
    });
    
})(jQuery);
