/*============== Main Js Start ========*/
(function ($) {
  "use strict";

  /*============== Header Hide Click On Body Js ========*/
  $(".navbar-toggler.header-button").on("click", function () {
    if ($(".body-overlay").hasClass("show")) {
      $(".body-overlay").removeClass("show");
    } else {
      $(".body-overlay").addClass("show");
    }
  });
  $(".body-overlay").on("click", function () {
    $(".header-button").trigger("click");
  });

  /* ==========================================
  *     Start Document Ready function
  ==========================================*/
  $(document).ready(function () {
    "use strict";
    if ($(".odometer").length) {
      var odo = $(".odometer");
      odo.each(function () {
        $(this).appear(function () {
          var countNumber = $(this).attr("data-count");
          $(this).html(countNumber);
        });
      });
    }

    /*================== Password Show Hide Js ==========*/
    $(".toggle-password").on("click", function () {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    /*================== Show Login Toggle Js ==========*/
    $("#showlogin").on("click", function () {
      $("#checkout-login").slideToggle(700);
    });

    /*================== Show Coupon Toggle Js ==========*/
    $("#showcupon").on("click", function () {
      $("#coupon-checkout").slideToggle(400);
    });

    /*======================= Mouse hover Js Start ============*/
    $(".mousehover-item").on("mouseover", function () {
      $(".mousehover-item").removeClass("active");
      $(this).addClass("active");
    });

    /*================== Sidebar Menu Js Start =============== */
    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").on("click", function () {
      $(".sidebar-submenu").slideUp(200);
      if ($(this).parent().hasClass("active")) {
        $(".has-dropdown").removeClass("active");
        $(this).parent().removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this).next(".sidebar-submenu").slideDown(200);
        $(this).parent().addClass("active");
      }
    });

    /*==================== Sidebar Icon & Overlay js ===============*/
    $(".dashboard-body__bar-icon").on("click", function () {
      $(".sidebar-menu").addClass("show-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass("show-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });

    /*======================= Event Details Like Js Start =======*/
    $(".hit-like").each(function () {
      $(this).on(
        click(function () {
          $(this).toggleClass("liked");
        })
      );
    });

    /* ========================= Odometer Counter Js Start ========== */
    $(".counterup-item").each(function () {
      $(this).isInViewport(function (status) {
        if (status === "entered") {
          for (
            var i = 0;
            i < document.querySelectorAll(".odometer").length;
            i++
          ) {
            var el = document.querySelectorAll(".odometer")[i];
            el.innerHTML = el.getAttribute("data-odometer-final");
          }
        }
      });
    });

    /*============** Number Increment Decrement **============*/
    $(".add").on("click", function () {
      if ($(this).prev().val() < 999) {
        $(this)
          .prev()
          .val(+$(this).prev().val() + 1);
      }
    });
    $(".sub").on("click", function () {
      if ($(this).next().val() > 1) {
        if ($(this).next().val() > 1)
          $(this)
            .next()
            .val(+$(this).next().val() - 1);
      }
    });

    /* =================== User Profile Upload Photo Js Start ========== */
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#imagePreview").css(
            "background-image",
            "url(" + e.target.result + ")"
          );
          $("#imagePreview").hide();
          $("#imagePreview").fadeIn(650);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").on("change", function () {
      readURL(this);
    });
  });
  /*==========================================
    *      End Document Ready function
    // ==========================================*/

  /*========================= Preloader Js Start =====================*/

  $(window).on("load", function () {
    $("#loading").fadeOut();
  });

  /*========================= Header Sticky Js Start ==============*/
  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 20) {
      $(".header").addClass("fixed-header");
    } else {
      $(".header").removeClass("fixed-header");
    }
  });

  /*============================ Scroll To Top Icon Js Start =========*/
  var btn = $(".scroll-top");

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });

  /*============================ Header Search =========*/

  $(".header-search-icon").on("click", function () {
    $(".header-search-hide-show").addClass("show");
    $(".header-search-icon").hide();
    $(".close-hide-show").addClass("show");
  });

  $(".close-hide-show").on("click", function () {
    $(".close-hide-show").removeClass("show");
    $(".header-search-hide-show").removeClass("show");
    $(".header-search-icon").show();
  });

  $(document).ready(function () {
    "use strict";
    var mode = localStorage.getItem("mode") || "light";
    updateMode(mode);
    if (mode == "dark") {
      
      $("#light-dark-checkbox").attr("checked", "checked");
    }

    $("#light-dark-checkbox,#light-dark-checkbox1").on("click", function () {
      mode = mode === "light" ? "dark" : "light";
      if (mode == "dark") {
        $(this).attr("checked", "checked");
      }
      updateMode(mode);
      localStorage.setItem("mode", mode);
    });

    function updateMode(mode) {
      if (mode === "dark") {
        $("body").addClass("dark").removeClass("light");
        $(".sun-icon").addClass("show");
        $(".mon-icon").addClass("show");
      } else {
        $("body").removeClass("dark").addClass("light");
        $(".mon-icon").removeClass("show");
        $(".sun-icon").removeClass("show");
      }

      // Add code for other element updates based on mode
      if (mode === "dark") {
        $("#normal-logo").addClass("hidden");
        $("#dark-logo").removeClass("hidden");
        $("#offcanvas-logo-normal").addClass("hidden");
        $("#offcanvas-logo-dark").removeClass("hidden");
        $("#messanger-logo-normal").addClass("hidden");
        $("#messanger-logo-dark").removeClass("hidden");
        // Update other logo-related classes as needed
      } else {
        $("#dark-logo").addClass("hidden");
        $("#normal-logo").removeClass("hidden");
        $("#offcanvas-logo-dark").addClass("hidden");
        $("#offcanvas-logo-normal").removeClass("hidden");
        $("#messanger-logo-dark").addClass("hidden");
        $("#messanger-logo-normal").removeClass("hidden");
        // Update other logo-related classes as needed
      }
    }
  });

  /*=== On page load, check the stored mode and apply it ===*/
  $(document).ready(function () {
    "use strict";
    var mode = localStorage.getItem("mode");
    if (mode === "dark") {
      $(".mon-icon").addClass("show");
      $(".sun-icon").addClass("show");
    } else {
      $(".mon-icon").removeClass("show");
      $(".sun-icon").removeClass("show");
    }
  });

  /*============================ header menu show hide =========*/
  $(".sidebar-menu-show-hide").on("click", function () {
    $(".sidebar-menu-wrapper").addClass("show");
    $(".sidebar-overlay").addClass("show");
  });

  $(".sidebar-overlay, .close-hide-show").on("click", function () {
    $(".sidebar-menu-wrapper").removeClass("show");
    $(".sidebar-overlay").removeClass("show");
  });

  /*---------- 05. Scroll To Top ----------*/
  // progressAvtivation
  if ($(".scroll-top").length > 0) {
    var scrollTopbtn = document.querySelector(".scroll-top");
    var progressPath = document.querySelector(".scroll-top path");
    var pathLength = progressPath.getTotalLength();
    progressPath.style.transition = progressPath.style.WebkitTransition =
      "none";
    progressPath.style.strokeDasharray = pathLength + " " + pathLength;
    progressPath.style.strokeDashoffset = pathLength;
    progressPath.getBoundingClientRect();
    progressPath.style.transition = progressPath.style.WebkitTransition =
      "stroke-dashoffset 10ms linear";
    var updateProgress = function () {
      var scroll = $(window).scrollTop();
      var height = $(document).height() - $(window).height();
      var progress = pathLength - (scroll * pathLength) / height;
      progressPath.style.strokeDashoffset = progress;
    };
    updateProgress();
    $(window).scroll(updateProgress);
    var offset = 50;
    var duration = 800;
    jQuery(window).on("scroll", function () {
      if (jQuery(this).scrollTop() > offset) {
        jQuery(scrollTopbtn).addClass("show");
      } else {
        jQuery(scrollTopbtn).removeClass("show");
      }
    });
    jQuery(scrollTopbtn).on("click", function (event) {
      event.preventDefault();
      jQuery("html, body").animate({ scrollTop: 0 }, duration);
      return false;
    });
  }

  // jquary for messenger

  $(function () {
    "use strict";
    var chatBox = $(".msg-list-wraper")[0];
    if (chatBox) {
      chatBox.scrollTop = chatBox.scrollHeight;
    } else {
    }
  });

  $(function () {
    "use strict";
    $(".chatBox-open-btn").on("click", function () {
      $(".chat-box").addClass("chat-box-show");
      // Scroll to the bottom of the chat box
      var chatBox = $(".msg-list-wraper")[0];
      chatBox.scrollTop = chatBox.scrollHeight;
    });
  });

  $(function () {
    "use strict";
    $(".chat-box-close-btn").on("click", function () {
      $(".chat-box").removeClass("chat-box-show");
    });
  });

  $(function () {
    "use strict";
    $(".chat-box-min-btn").on("click", function () {
      $(".chat-body").toggleClass("hide-chat-body");
    });
  });
  // jquary for messenger end

  // forum card dropdown
  $(document).ready(function () {
    "use strict";
    function toggleClassOnClick(element, className) {
      $(element).on("click", function () {
        $(element).toggleClass(className);
      });
    }

    function closeAllDropdowns() {
      $(".actn-dropdown").removeClass("is-open-actn-dropdown");
    }

    $(".forum-card .actn-dropdown-box").each(function () {
      toggleClassOnClick($(this), "is-open-actn-dropdown");
    });

    $(document).on("click", ".actn-dropdown-btn", function (event) {
      event.stopPropagation();
      var dropdownBox = $(this).closest(".actn-dropdown-box");
      var dropdown = dropdownBox.find(".actn-dropdown");
      closeAllDropdowns();
      dropdown.addClass("is-open-actn-dropdown");
    });

    $(document).on("click", function (event) {
      var clickedElement = $(event.target);

      if (!clickedElement.closest(".actn-dropdown-box").length) {
        closeAllDropdowns();
      }
    });
  });

  // vote active class
  $(document).ready(function () {
    "use strict";
    $(".vote-qty__increment, .vote-qty__decrement").on("click", function () {
      var clickedButton = $(this);
      clickedButton.toggleClass(
        "active-upvote",
        clickedButton.hasClass("vote-qty__increment")
      );
      clickedButton.toggleClass(
        "active-downvote",
        clickedButton.hasClass("vote-qty__decrement")
      );

      clickedButton.find("i").toggleClass("fa-solid fa-regular");

      clickedButton
        .siblings(".vote-qty__increment, .vote-qty__decrement")
        .removeClass("active-upvote active-downvote")
        .find("i")
        .removeClass("fa-solid")
        .addClass("fa-regular");
    });
  });

  // message settings
  $(document).ready(function () {
    "use strict";
    $(".msg-setting-btn").on("click", function () {
      $(".message-body-header").toggleClass("msg-setting-show");
    });
    $(document).on('click', function (event) {
      if (!$(event.target).closest(".msg-setting-btn").length) {
        $(".message-body-header").removeClass("msg-setting-show");
      }
    });
  });

  // header serach bar
  $(function () {
    "use strict";
    $(".search-icon").on("click", function () {
      $(".header-search-bar").toggleClass("active-search-bar");
      $(".logo-wrapper").toggleClass("hide-logo");
    });
  });

  // emoji
  $(document).ready(function () {
    "use strict";
    $(".emoji-text").emojioneArea({
      pickerPosition: "top",
    });
  });

  // open msg list
  $(document).ready(function () {
    "use strict";
    $(".open-message-list-btn").on("click", function () {
      $(".message-left").toggleClass("message-list-show");
    });
    $(document).on("click", function (event) {
      if (!$(event.target).closest(".message-left").length) {
        $(".message-left").removeClass("message-list-show");
      }
    });
  });

  $(document).ready(function () {
    "use strict";
    let attFile;
    const attFileName = $(".att-file-name");
    const attUploadBtn = $(".att-file-upload");
    const attUploadInput = $(".att-upload-input");

    attUploadBtn.on("click", function () {
      attUploadInput.click();
    });

    attUploadInput.on("change", function () {
      attFile = this.files[0];
      attFileName.text(attFile.name);
    });
  });

  // eye animation
  $("body").on("mousemove", eyeball);
  function eyeball(event) {
    $(".eye").each(function () {
      let eye = $(this);
      let x = eye.offset().left + eye.width() / 2;
      let y = eye.offset().top + eye.height() / 2;

      let radian = Math.atan2(event.pageX - x, event.pageY - y);
      let rotation = radian * (180 / Math.PI) * -1 + 270;
      eye.css("transform", "rotate(" + rotation + "deg)");
    });
  }

  // show all menu item
  $(document).ready(function () {
    "use strict";
    const $contentDiv = $(".show-all-menu-wraper");
    const $showAllElements = $(".show-all");
    const $showAllButton = $(".show-all-tgl-btn");

    $showAllButton.on("click", function () {
      $contentDiv.toggleClass("show-all");
      $showAllElements.toggleClass("show-all");

      if ($contentDiv.hasClass("show-all")) {
        $showAllButton.text("See Less");
      } else {
        $showAllButton.text("See More");
      }
    });
  });

  const lightbox = GLightbox({
    touchNavigation: true,
    loop: true,
  
    
  });
  

  // photo grid
  
})(jQuery);
