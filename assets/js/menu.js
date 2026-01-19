/**
 * Navigation Menu Scripts
 */

(function($) {
    'use strict';
    
    // 모바일 메뉴 토글
    function initMobileMenu() {
        const menuToggle = $('.menu-toggle');
        const mainNav = $('#primary-menu');
        const body = $('body');
        
        if (menuToggle.length && mainNav.length) {
            menuToggle.on('click', function(e) {
                e.preventDefault();
                
                const isExpanded = $(this).attr('aria-expanded') === 'true';
                
                $(this).attr('aria-expanded', !isExpanded);
                mainNav.toggleClass('active');
                body.toggleClass('mobile-menu-open');
                
                // 아이콘 변경
                $(this).find('.icon-menu-bars svg').toggle();
            });
            
            // 메뉴 외부 클릭시 닫기
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.main-navigation').length && mainNav.hasClass('active')) {
                    menuToggle.attr('aria-expanded', 'false');
                    mainNav.removeClass('active');
                    body.removeClass('mobile-menu-open');
                    menuToggle.find('.icon-menu-bars svg').toggle();
                }
            });
            
            // ESC 키로 닫기
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && mainNav.hasClass('active')) {
                    menuToggle.attr('aria-expanded', 'false');
                    mainNav.removeClass('active');
                    body.removeClass('mobile-menu-open');
                    menuToggle.find('.icon-menu-bars svg').toggle();
                }
            });
        }
    }
    
    // 서브메뉴 처리
    function initSubMenus() {
        const menuItems = $('.menu-item-has-children');
        
        if (menuItems.length) {
            menuItems.each(function() {
                const $this = $(this);
                const subMenu = $this.find('> .sub-menu');
                
                if (subMenu.length) {
                    // 드롭다운 토글 버튼 추가
                    const toggleButton = $('<button>', {
                        'class': 'dropdown-toggle',
                        'aria-expanded': 'false',
                        'aria-label': '서브메뉴 토글'
                    }).html('<span class="dropdown-icon">▼</span>');
                    
                    $this.find('> a').after(toggleButton);
                    
                    // 모바일에서 클릭으로 열기
                    toggleButton.on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const isExpanded = $(this).attr('aria-expanded') === 'true';
                        
                        // 다른 열린 서브메뉴 닫기
                        menuItems.find('.dropdown-toggle').not(this).attr('aria-expanded', 'false');
                        menuItems.find('.sub-menu').not(subMenu).slideUp(200);
                        
                        // 현재 서브메뉴 토글
                        $(this).attr('aria-expanded', !isExpanded);
                        subMenu.slideToggle(200);
                    });
                    
                    // 데스크톱에서 hover
                    if (window.innerWidth > 768) {
                        $this.hover(
                            function() {
                                subMenu.stop(true, true).fadeIn(200);
                            },
                            function() {
                                subMenu.stop(true, true).fadeOut(200);
                            }
                        );
                    }
                }
            });
        }
    }
    
    // 현재 페이지 메뉴 하이라이트
    function highlightCurrentPage() {
        const currentUrl = window.location.href;
        const menuLinks = $('.main-nav a');
        
        menuLinks.each(function() {
            const linkUrl = $(this).attr('href');
            
            if (currentUrl === linkUrl || currentUrl.indexOf(linkUrl) === 0) {
                $(this).parent().addClass('current-menu-item');
            }
        });
    }
    
    // 스크롤시 네비게이션 스타일 변경
    function initStickyNav() {
        const nav = $('.main-navigation');
        const navOffset = nav.offset().top;
        
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > navOffset) {
                nav.addClass('sticky');
            } else {
                nav.removeClass('sticky');
            }
        });
    }
    
    // 키보드 네비게이션 접근성
    function initKeyboardNav() {
        const menuLinks = $('.main-nav a, .menu-toggle, .dropdown-toggle');
        
        menuLinks.on('keydown', function(e) {
            const $this = $(this);
            
            // Tab 키
            if (e.key === 'Tab') {
                // 마지막 항목에서 Tab을 누르면 메뉴 닫기
                if ($this.is(':last-child') && !e.shiftKey) {
                    setTimeout(function() {
                        $('.main-nav').removeClass('active');
                        $('.menu-toggle').attr('aria-expanded', 'false');
                        $('body').removeClass('mobile-menu-open');
                    }, 100);
                }
            }
            
            // Enter 또는 Space 키
            if (e.key === 'Enter' || e.key === ' ') {
                if ($this.hasClass('dropdown-toggle')) {
                    e.preventDefault();
                    $this.click();
                }
            }
            
            // Escape 키
            if (e.key === 'Escape') {
                if ($this.closest('.sub-menu').length) {
                    $this.closest('.menu-item-has-children').find('> .dropdown-toggle').focus();
                    $this.closest('.sub-menu').slideUp(200);
                }
            }
        });
    }
    
    // 윈도우 리사이즈 처리
    function handleResize() {
        let resizeTimer;
        
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // 데스크톱 크기로 변경시 모바일 메뉴 상태 초기화
                if (window.innerWidth > 768) {
                    $('.main-nav').removeClass('active');
                    $('.menu-toggle').attr('aria-expanded', 'false');
                    $('body').removeClass('mobile-menu-open');
                    $('.sub-menu').removeAttr('style');
                }
            }, 250);
        });
    }
    
    // 초기화
    $(document).ready(function() {
        initMobileMenu();
        initSubMenus();
        highlightCurrentPage();
        initStickyNav();
        initKeyboardNav();
        handleResize();
    });
    
})(jQuery);
