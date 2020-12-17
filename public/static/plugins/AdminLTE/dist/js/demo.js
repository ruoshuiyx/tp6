/**
 * AdminLTE SIYUCMS
 */

(function ($) {
  // 初始化风格
  setup()

  // 严格模式
  'use strict'

  var $sidebar = $('.control-sidebar')
  var $container = $('<div />', {
    class: 'p-3 control-sidebar-content'
  })

  $sidebar.append($container)

  var navbar_dark_skins = [
    'navbar-primary',
    'navbar-secondary',
    'navbar-info',
    'navbar-success',
    'navbar-danger',
    'navbar-indigo',
    'navbar-purple',
    'navbar-pink',
    'navbar-navy',
    'navbar-lightblue',
    'navbar-teal',
    'navbar-cyan',
    'navbar-dark',
    'navbar-gray-dark',
    'navbar-gray'
  ]

  var navbar_light_skins = [
    'navbar-light',
    'navbar-warning',
    'navbar-white',
    'navbar-orange'
  ]

  $container.append('<h5>自定义</h5><hr class="mb-2"/>')

  var $clear_all_btn = $('<small />', {
    class: 'float-right',
    style: 'margin-top: -2.8rem;cursor: pointer;',
  }).text('[还原]').on('click', function (e) {
    e.preventDefault()
    clearAll()
  })
  $container.append($clear_all_btn)

  // 整体字号变小
  var $text_sm_body_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('text-sm')
      store('text_sm_body_checkbox', 1)
    } else {
      $('body').removeClass('text-sm')
      store('text_sm_body_checkbox', 0)
    }
  })
  var $text_sm_body_container = $('<div />', {class: 'mb-1'}).append($text_sm_body_checkbox).append('<span>整体字号变小</span>')
  $container.append($text_sm_body_container)

  // 底部字号变小
  var $text_sm_footer_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-footer').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-footer').addClass('text-sm')
      store('text_sm_footer_checkbox', 1)
    } else {
      $('.main-footer').removeClass('text-sm')
      store('text_sm_footer_checkbox', 0)
    }
  })
  var $text_sm_footer_container = $('<div />', {class: 'mb-1'}).append($text_sm_footer_checkbox).append('<span>底部字号变小</span>')
  $container.append($text_sm_footer_container)

  // Logo字号变小
  var $text_sm_brand_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.brand-link').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.brand-link').addClass('text-sm')
      store('text_sm_brand_checkbox', 1)
    } else {
      $('.brand-link').removeClass('text-sm')
      store('text_sm_brand_checkbox', 0)
    }
  })
  var $text_sm_brand_container = $('<div />', {class: 'mb-3'}).append($text_sm_brand_checkbox).append('<span>Logo字号变小</span>')
  $container.append($text_sm_brand_container)

  // 固定导航栏
  var $navbar_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-navbar-fixed'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-navbar-fixed')
      store('navbar_fixed_checkbox', 1)
    } else {
      $('body').removeClass('layout-navbar-fixed')
      store('navbar_fixed_checkbox', 0)
    }
  })
  var $navbar_fixed_container = $('<div />', {class: 'mb-1'}).append($navbar_fixed_checkbox).append('<span>固定导航栏</span>')
  $container.append($navbar_fixed_container)

  // 固定底部
  var $footer_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-footer-fixed'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-footer-fixed')
      store('footer_fixed_checkbox', 1)
    } else {
      $('body').removeClass('layout-footer-fixed')
      store('footer_fixed_checkbox', 0)
    }
  })
  var $footer_fixed_container = $('<div />', {class: 'mb-3'}).append($footer_fixed_checkbox).append('<span>固定底部</span>')
  $container.append($footer_fixed_container)


  // 导航栏边框隐藏
  var $no_border_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('border-bottom-0'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('border-bottom-0')
      store('no_border_checkbox', 1)
    } else {
      $('.main-header').removeClass('border-bottom-0')
      store('no_border_checkbox', 0)
    }
  })
  var $no_border_container = $('<div />', {class: 'mb-1'}).append($no_border_checkbox).append('<span>导航栏边框隐藏</span>')
  $container.append($no_border_container)

  // 导航栏字号变小
  var $text_sm_header_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('text-sm')
      store('text_sm_header_checkbox', 1)
    } else {
      $('.main-header').removeClass('text-sm')
      store('text_sm_header_checkbox', 0)
    }
  })
  var $text_sm_header_container = $('<div />', {class: 'mb-3'}).append($text_sm_header_checkbox).append('<span>导航栏字号变小</span>')
  $container.append($text_sm_header_container)

  // 主体区域直角风格
  var $radius_content_main_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('content_main-radius'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('body').addClass('content_main-radius')
      store('radius_content_main_checkbox', 1)
    } else {
      $('body').removeClass('content_main-radius')
      store('radius_content_main_checkbox', 0)
    }
  })
  var $radius_content_main_container = $('<div />', {class: 'mb-3'}).append($radius_content_main_checkbox).append('<span>主体区域直角风格</span>')
  $container.append($radius_content_main_container)


  // 侧边栏阴影隐藏
  var $no_sidebar_border_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-sidebar').hasClass('elevation-1'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-sidebar').removeClass('elevation-4').addClass('elevation-1')
      store('no_sidebar_border_checkbox', 1)
    } else {
      $('.main-sidebar').removeClass('elevation-1').addClass('elevation-4')
      store('no_sidebar_border_checkbox', 0)
    }
  })
  var $no_sidebar_border_container = $('<div />', {class: 'mb-1'}).append($no_sidebar_border_checkbox).append('<span>侧边栏阴影隐藏</span>')
  $container.append($no_sidebar_border_container)

  // 侧边栏字号变小
  var $text_sm_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('text-sm')
      store('text_sm_sidebar_checkbox', 1)
    } else {
      $('.nav-sidebar').removeClass('text-sm')
      store('text_sm_sidebar_checkbox', 0)
    }
  })
  var $text_sm_sidebar_container = $('<div />', {class: 'mb-1'}).append($text_sm_sidebar_checkbox).append('<span>侧边栏字号变小</span>')
  $container.append($text_sm_sidebar_container)

  // 侧边栏导航直角风格
  var $radius_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('no_radius'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('no_radius')
      store('radius_sidebar_checkbox', 1)
    } else {
      $('.nav-sidebar').removeClass('no_radius')
      store('radius_sidebar_checkbox', 0)
    }
  })
  var $radius_sidebar_container = $('<div />', {class: 'mb-1'}).append($radius_sidebar_checkbox).append('<span>侧边栏导航直角风格</span>')
  $container.append($radius_sidebar_container)

  // 侧边栏导航扁平风格
  var $flat_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-flat'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-flat')
      store('flat_sidebar_checkbox', 1)
    } else {
      $('.nav-sidebar').removeClass('nav-flat')
      store('flat_sidebar_checkbox', 0)
    }
  })
  var $flat_sidebar_container = $('<div />', {class: 'mb-1'}).append($flat_sidebar_checkbox).append('<span>侧边栏导航扁平风格</span>')
  $container.append($flat_sidebar_container)

  // 侧边栏导航传统风格
  var $legacy_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-legacy'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-legacy')
      store('legacy_sidebar_checkbox', 1)
    } else {
      $('.nav-sidebar').removeClass('nav-legacy')
      store('legacy_sidebar_checkbox', 0)
    }
  })
  var $legacy_sidebar_container = $('<div />', {class: 'mb-1'}).append($legacy_sidebar_checkbox).append('<span>侧边栏导航传统风格</span>')
  $container.append($legacy_sidebar_container)

  // 侧边栏导航压缩
  var $compact_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-compact'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-compact')
      store('compact_sidebar_checkbox', 1)
    } else {
      $('.nav-sidebar').removeClass('nav-compact')
      store('compact_sidebar_checkbox', 0)
    }
  })
  var $compact_sidebar_container = $('<div />', {class: 'mb-1'}).append($compact_sidebar_checkbox).append('<span>侧边栏导航压缩</span>')
  $container.append($compact_sidebar_container)

  // 侧边栏子导航缩进
  var $child_indent_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-child-indent'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-child-indent')
      store('child_indent_sidebar_checkbox', 1)
    } else {
      $('.nav-sidebar').removeClass('nav-child-indent')
      store('child_indent_sidebar_checkbox', 0)
    }
  })
  var $child_indent_sidebar_container = $('<div />', {class: 'mb-1'}).append($child_indent_sidebar_checkbox).append('<span>侧边栏子导航缩进</span>')
  $container.append($child_indent_sidebar_container)

  // 侧边栏子导航折叠时隐藏
  var $child_hide_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-collapse-hide-child'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-collapse-hide-child')
      store('child_hide_sidebar_checkbox', 1)
    } else {
      $('.nav-sidebar').removeClass('nav-collapse-hide-child')
      store('child_hide_sidebar_checkbox', 0)
    }
  })
  var $child_hide_sidebar_container = $('<div />', {class: 'mb-1'}).append($child_hide_sidebar_checkbox).append('<span>侧边栏子导航折叠时隐藏</span>')
  $container.append($child_hide_sidebar_container)

  // 侧边栏禁用悬停时自动展开
  var $no_expand_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-sidebar').hasClass('sidebar-no-expand'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-sidebar').addClass('sidebar-no-expand')
      store('no_expand_sidebar_checkbox', 1)
    } else {
      $('.main-sidebar').removeClass('sidebar-no-expand')
      store('no_expand_sidebar_checkbox', 0)
    }
  })
  var $no_expand_sidebar_container = $('<div />', {class: 'mb-1'}).append($no_expand_sidebar_checkbox).append('<span>侧边栏禁用悬停时自动展开</span>')
  $container.append($no_expand_sidebar_container)

  $container.append('<h6 class="mt-4">导航栏风格</h6>')

  var $navbar_variants = $('<div />', {
    class: 'd-flex'
  })
  var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins)
  var $navbar_variants_colors = createSkinBlock(navbar_all_colors, function () {
    var color = $(this).data('color')
    var store_color = color
    var $main_header = $('.main-header')
    $main_header.removeClass('navbar-dark').removeClass('navbar-light')
    navbar_all_colors.forEach(function (color) {
      $main_header.removeClass(color)
    })

    if (navbar_dark_skins.indexOf(color) > -1) {
      $main_header.addClass('navbar-dark')
      store_color = 'navbar-dark ' + store_color
    } else {
      $main_header.addClass('navbar-light')
      store_color = 'navbar-light ' + store_color
    }

    $main_header.addClass(color)
    store('navbar_skin', store_color)
  })

  $navbar_variants.append($navbar_variants_colors)

  $container.append($navbar_variants)

  var sidebar_colors = [
    'bg-primary',
    'bg-warning',
    'bg-info',
    'bg-danger',
    'bg-success',
    'bg-indigo',
    'bg-lightblue',
    'bg-navy',
    'bg-purple',
    'bg-fuchsia',
    'bg-pink',
    'bg-maroon',
    'bg-orange',
    'bg-lime',
    'bg-teal',
    'bg-olive',
    'bg-default',
  ]

  var sidebar_skins = [
    'sidebar-dark-primary',
    'sidebar-dark-warning',
    'sidebar-dark-info',
    'sidebar-dark-danger',
    'sidebar-dark-success',
    'sidebar-dark-indigo',
    'sidebar-dark-lightblue',
    'sidebar-dark-navy',
    'sidebar-dark-purple',
    'sidebar-dark-fuchsia',
    'sidebar-dark-pink',
    'sidebar-dark-maroon',
    'sidebar-dark-orange',
    'sidebar-dark-lime',
    'sidebar-dark-teal',
    'sidebar-dark-olive',
    'sidebar-dark-default',
    'sidebar-light-primary',
    'sidebar-light-warning',
    'sidebar-light-info',
    'sidebar-light-danger',
    'sidebar-light-success',
    'sidebar-light-indigo',
    'sidebar-light-lightblue',
    'sidebar-light-navy',
    'sidebar-light-purple',
    'sidebar-light-fuchsia',
    'sidebar-light-pink',
    'sidebar-light-maroon',
    'sidebar-light-orange',
    'sidebar-light-lime',
    'sidebar-light-teal',
    'sidebar-light-olive',
    'sidebar-light-default',
  ]

  $container.append('<h6>黑暗侧边栏风格</h6>')
  var $sidebar_variants_dark = $('<div />', {
    class: 'd-flex'
  })
  $container.append($sidebar_variants_dark)
  $container.append(createSkinBlock(sidebar_colors, function () {
    var color = $(this).data('color')
    var sidebar_class = 'sidebar-dark-' + color.replace('bg-', '')
    var $sidebar = $('.main-sidebar')
    sidebar_skins.forEach(function (skin) {
      $sidebar.removeClass(skin)
    })

    $sidebar.addClass(sidebar_class)
    store('sidebar_skin', sidebar_class)
  }))

  $container.append('<h6>明亮侧边栏风格</h6>')
  var $sidebar_variants_light = $('<div />', {
    class: 'd-flex'
  })
  $container.append($sidebar_variants_light)
  $container.append(createSkinBlock(sidebar_colors, function () {
    var color = $(this).data('color')
    var sidebar_class = 'sidebar-light-' + color.replace('bg-', '')
    var $sidebar = $('.main-sidebar')
    sidebar_skins.forEach(function (skin) {
      $sidebar.removeClass(skin)
    })

    $sidebar.addClass(sidebar_class)
    store('sidebar_skin', sidebar_class)
  }))

  var logo_skins = navbar_all_colors
  $container.append('<h6>LOGO风格</h6>')
  var $logo_variants = $('<div />', {
    class: 'd-flex'
  })
  $container.append($logo_variants)
  var $clear_btn = $('<a />', {
    href: '#'
  }).text('clear').on('click', function (e) {
    e.preventDefault()
    var $logo = $('.brand-link')
    logo_skins.forEach(function (skin) {
      $logo.removeClass(skin)
      store('logo_skin', '')
    })
  })
  $container.append(createSkinBlock(logo_skins, function () {
    var color = $(this).data('color')
    var $logo = $('.brand-link')
    logo_skins.forEach(function (skin) {
      $logo.removeClass(skin)
    })
    $logo.addClass(color)
    store('logo_skin', color)
  }).append($clear_btn))

  function createSkinBlock(colors, callback) {
    var $block = $('<div />', {
      class: 'd-flex flex-wrap mb-3'
    })

    colors.forEach(function (color) {
      var $color = $('<div />', {
        class: (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-') + ' elevation-2'
      })

      $block.append($color)

      $color.data('color', color)

      $color.css({
        width: '40px',
        height: '20px',
        borderRadius: '25px',
        marginRight: 10,
        marginBottom: 10,
        opacity: 0.8,
        cursor: 'pointer'
      })

      $color.hover(function () {
        $(this).css({ opacity: 1 }).removeClass('elevation-2').addClass('elevation-4')
      }, function () {
        $(this).css({ opacity: 0.8 }).removeClass('elevation-4').addClass('elevation-2')
      })

      if (callback) {
        $color.on('click', callback)
      }
    })

    return $block
  }

  /**
   * Get a prestored setting
   *
   * @param String name Name of of the setting
   * @returns String The value of the setting | null
   */
  function get(name) {
    if (typeof (Storage) !== 'undefined') {
      return localStorage.getItem(name)
    } else {
      window.alert('Please use a modern browser to properly view this template!')
    }
  }

  /**
   * Store a new settings in the browser
   *
   * @param String name Name of the setting
   * @param String val Value of the setting
   * @returns void
   */
  function store(name, val) {
    if (typeof (Storage) !== 'undefined') {
      localStorage.setItem(name, val)
    } else {
      window.alert('浏览器版本太低，请升级或更换浏览器!')
    }
  }

  /**
   * 还原默认风格
   */
  function clearAll() {
    if (typeof (Storage) !== 'undefined') {
      localStorage.clear()
      window.location.reload()
    } else {
      window.alert('浏览器版本太低，请升级或更换浏览器!')
    }
  }

  /**
   * Retrieve default settings and apply them to the template
   *
   * @returns void
   */
  function setup() {
    // LOGO
    var logo_skin = get('logo_skin')
    if (logo_skin) {
      $('.brand-link').addClass(logo_skin)
    }

    // slidebar
    var sidebar_skin = get('sidebar_skin')
    if (sidebar_skin) {
      var $sidebar = $('.main-sidebar')
      $sidebar.removeClass('sidebar-dark-primary').removeClass('sidebar-light-primary').removeClass('sidebar-dark-default').removeClass('sidebar-light-default')
      $sidebar.addClass(sidebar_skin)
    }

    // navbar
    var navbar_skin = get('navbar_skin')
    if (navbar_skin) {
      var $main_header = $('.main-header')
      $main_header.removeClass('navbar-dark').removeClass('navbar-light').removeClass('navbar-white')
      $main_header.addClass(navbar_skin)
    }

    // no_border_checkbox
    var no_border_checkbox = get('no_border_checkbox')
    if (no_border_checkbox && no_border_checkbox == 1) {
      $('.main-header').addClass('border-bottom-0')
    }

    // no_sidebar_border_checkbox
    var no_sidebar_border_checkbox = get('no_sidebar_border_checkbox')
    if (no_sidebar_border_checkbox && no_sidebar_border_checkbox == 1) {
      $('.main-sidebar').removeClass('elevation-4').addClass('elevation-1')
    }

    // text_sm_body_checkbox
    var text_sm_body_checkbox = get('text_sm_body_checkbox')
    if (text_sm_body_checkbox && text_sm_body_checkbox == 0) {
      $('body').removeClass('text-sm')
    }

    // text_sm_header_checkbox
    var text_sm_header_checkbox = get('text_sm_header_checkbox')
    if (text_sm_header_checkbox && text_sm_header_checkbox == 1) {
      $('.main-header').addClass('text-sm')
    }

    // text_sm_sidebar_checkbox
    var text_sm_sidebar_checkbox = get('text_sm_sidebar_checkbox')
    if (text_sm_sidebar_checkbox && text_sm_sidebar_checkbox == 1) {
      $('.nav-sidebar').addClass('text-sm')
    }

    // text_sm_footer_checkbox
    var text_sm_footer_checkbox = get('text_sm_footer_checkbox')
    if (text_sm_footer_checkbox && text_sm_footer_checkbox == 1) {
      $('.main-footer').addClass('text-sm')
    }

    // radius_sidebar_checkbox
    var radius_sidebar_checkbox = get('radius_sidebar_checkbox')
    if (radius_sidebar_checkbox && radius_sidebar_checkbox == 1) {
      $('.nav-sidebar').addClass('no_radius')
    } else {
      $('.nav-sidebar').removeClass('no_radius')
    }

    // flat_sidebar_checkbox
    var flat_sidebar_checkbox = get('flat_sidebar_checkbox')
    if (flat_sidebar_checkbox && flat_sidebar_checkbox == 1) {
      $('.nav-sidebar').addClass('nav-flat')
    }

    // legacy_sidebar_checkbox
    var legacy_sidebar_checkbox = get('legacy_sidebar_checkbox')
    if (legacy_sidebar_checkbox && legacy_sidebar_checkbox == 1) {
      $('.nav-sidebar').addClass('nav-legacy')
    }

    // compact_sidebar_checkbox
    var compact_sidebar_checkbox = get('compact_sidebar_checkbox')
    if (compact_sidebar_checkbox && compact_sidebar_checkbox == 1) {
      $('.nav-sidebar').addClass('nav-compact')
    }

    // child_indent_sidebar_checkbox
    var child_indent_sidebar_checkbox = get('child_indent_sidebar_checkbox')
    if (child_indent_sidebar_checkbox && child_indent_sidebar_checkbox == 0) {
      $('.nav-sidebar').removeClass('nav-child-indent')
    }

    // child_hide_sidebar_checkbox
    var child_hide_sidebar_checkbox = get('child_hide_sidebar_checkbox')
    if (child_hide_sidebar_checkbox && child_hide_sidebar_checkbox == 1) {
      $('.nav-sidebar').addClass('nav-collapse-hide-child')
    }

    // no_expand_sidebar_checkbox
    var no_expand_sidebar_checkbox = get('no_expand_sidebar_checkbox')
    if (no_expand_sidebar_checkbox && no_expand_sidebar_checkbox == 1) {
      $('.main-sidebar').addClass('sidebar-no-expand')
    }

    // text_sm_brand_checkbox
    var text_sm_brand_checkbox = get('text_sm_brand_checkbox')
    if (text_sm_brand_checkbox && text_sm_brand_checkbox == 1) {
      $('.brand-link').addClass('text-sm')
    }

    // navbar_fixed_checkbox
    var navbar_fixed_checkbox = get('navbar_fixed_checkbox')
    if (navbar_fixed_checkbox && navbar_fixed_checkbox == 0) {
      $('body').removeClass('layout-navbar-fixed')
    }

    // footer_fixed_checkbox
    var footer_fixed_checkbox = get('footer_fixed_checkbox')
    if (footer_fixed_checkbox && footer_fixed_checkbox == 1) {
      $('body').addClass('layout-footer-fixed')
    }

    // radius_content_main_checkbox
    var radius_content_main_checkbox = get('radius_content_main_checkbox')
    if (radius_content_main_checkbox && radius_content_main_checkbox == 1) {
      $('body').addClass('content_main-radius')
    }

  }

})(jQuery)
