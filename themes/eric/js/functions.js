/**
 * Provides helper functions to enhance the theme experience.
 */

var $ = jQuery;
var emailfilter = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
var hash;
var request;

var siteURL = get_hostname(document.location.href);
var uploadURL = siteURL + '/upload';
var ajaxURL = siteURL + '/ajax';
//siteURL += '/equalrating';

( function( $ ) {
  $.fn.equalizeHeights = function(){
    return this.height( Math.max.apply(this, $(this).map(function(i,e){return $(e).height()}).get() ) )
  };
  
  function scrollToElement(selector, time, verticalOffset, callback) {
    time = typeof(time) != 'undefined' ? time : 500;
    verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $(selector);
    offset = element.offset();
    offsetTop = offset.top + verticalOffset;
    t = ($(window).scrollTop() - offsetTop);
    if (t <= 0) t *= -1;
    t = parseInt(t * .5);
    if (t < time) t=time;
    if (t > 1500) t=1500;
    $('html, body').animate({
      scrollTop: offsetTop
    }, t, 'easeInOutCirc', callback);
  }
  
  function showHideTopButton() {
    $btnTop = $('#goTop');
    if ($(window).scrollTop() > 300) { 
			$btnTop.fadeIn(); 
		} else { 
			$btnTop.fadeOut(); 
		}
  }
  
  
  function showRequest(formData, jqForm, options) {
    var isValid = true;
    
    if(isValid) {
      $('body').showLoading();
    }
    
    return true;
  }

  function showResponse(responseText, statusText, xhr, jqForm) {
    if (statusText===" success" || statusText==="success"){
//      var url = window.location.href;
//      url = url.split("?")[0];
//      url += '?secret='+$('#secret', jqForm).val()+'&success='+responseText.success;

      var url = siteURL + '/submissions';
      window.location.href = url;
    }
  }
  
  
  function verticalCenter() {
    if($('.vertical-center').length > 0) {
      $('.vertical-center').each(function() {
        var $item = $(this);
        var parentClass = $item.attr('data-parent');
        var $parent = $item.parents($('.'+parentClass));
        if($parent) {
          itemPadding = ($parent.height() - $item.height())/2;
          $item.css({'padding-top':itemPadding+'px', 'padding-bottom':itemPadding+'px'});
        }
      });
    }
  }
  
  function configureExternalLinkTarget() {
    $('a').not('[href*="mailto:"]').each(function () {
      var isInternalLink = new RegExp('/' + window.location.host + '/');
      if ( ! isInternalLink.test(this.href) ) {
        $(this).attr('target', '_blank');
      }
    });
  }
  
  function loadWindow() {
    configureExternalLinkTarget();
  }
  
  function resizeWindow() {
    // add functions/script here for window resizing
  }
  
  function scrollWindow() {
    showHideTopButton();
  }


  var body    = $( 'body' ), _window = $( window );
  ( function() {
    loadWindow();
    $(window).resize(resizeWindow);
    $(window).scroll(scrollWindow);
    
    if(window.location.hash) {
      var hash = window.location.hash.replace('#',"");
      if($('#'+hash).length > 0) {
        scrollToElement($('#'+hash), 400, 0);
      } else if($('.'+hash).length > 0) {
        scrollToElement($('.'+hash+':eq(0)'), 400, -30);
      }
      
      $("a[href*=#]").not($('a[href*=#'+hash+']')).parents('li').removeClass('current-menu-item');
    } else {
      $("a[href*=#]").parents('li').removeClass('current-menu-item');
    }
    
    $('.current_page_ancestor a[href*=#]').each(function() {
      var $item = $(this);
      $item.click(function(e) {
//        e.preventDefault();
        var $parent = $item.parent('li');
        var hash = $(this).attr('href').split('#')[1];
        scrollToElement($('#'+hash+':eq(0)'), 400, -30);
        $parent.addClass('current-menu-item');
        $("a[href*=#]").not($('a[href*=#'+hash+']')).parents('li').removeClass('current-menu-item');
      });
    });
    
    if($(".btn-submit-evaluation").length > 0) {
      $(".btn-submit-evaluation").each(function() {
        var $item = $(this);
        var $parent = $item.parents('.tbl-row');
        var $link = $('a', $item);
        
        $link.click(function(e) {
          e.preventDefault();
          $.confirm({
            title: 'Confirm!',
            content: 'Would like to submit your score?',
            type: 'green',
            buttons: {
              confirm: {
                text: 'Yes',
                btnClass: 'btn-primary',
                action: function() {
                  var itemInfo = {
                    secret: $item.data('secret'),
                    action: 'submit'
                  };
                  $('body').showLoading();
                  $.ajax({
                    url: siteURL+'/evaluation/submit',
                    type: 'post',
                    dataType: 'json',
                    data: itemInfo,
                    success: function (data) {
                      $('body').hideLoading();
                      if(data.success==1) {
                        $item.html('<strong>SUBMITTED</strong>');
                        $('.evaluate-now', $parent).text('<strong>Evaluation completed</strong>');
                      }
                      $.alert({
                        title: data.message,
                        content: ''
                      });
                    }
                  });
                }
              },
              cancel: {
                text: 'No'
              }
            }
          });
        });
      });
    }
    
    if($('.ajax-form').length > 0) {
      $('.ajax-form').each(function() {
        var $form = $(this);
        var options = {
          beforeSubmit:  showRequest, 
          success: showResponse
        };
        
        $form.submit(function() {
          $(this).ajaxSubmit(options);
          return false;
        });
      });
    }
    
    
    
    if($('#submissionForm').length > 0) {
      $('input[type=radio][name="opensource_solution"]').change(function() {
        if (this.value === 'No') {
          $('#opensource_solution_info').addClass('required');
        } else {
          $('#opensource_solution_info').removeClass('required has-error');
        }
      });
      
      
      $('#submissionForm').submit(function() {
        var $form = $(this);
        isValid = true;
        
        $('.submission-form-message').empty().removeClass('error success');
        $('.has-error').removeClass('has-error');
        
        if(isValid) {
          $('.field-input.required', $form).each(function() {
            if($(this).parents('.hidden-xs-up').length > 0) return;
            if($(this).val().replace(/^\s*|\s*$/g,"")=="") {
              $(this).addClass('has-error');
              isValid=false;
            }
          });
          if(!(isValid)) err_msg = "Please complete the highlighted fields in order to Submit.";
        }

        if(isValid) {
          $('.field-input.email', $form).each(function() {
            if($(this).parents('.hidden-xs-up').length > 0) return;
            if($(this).val().replace(/^\s*|\s*$/g,"")=="") return;
            
            if(isValid && emailfilter.test($(this).val())==false) {
              $(this).addClass('has-error');
              isValid = false;
            }
          });
          if(!(isValid)) err_msg = "Please complete the highlighted fields in order to Submit.";
        }
        
        if(isValid) {
          if($('#agree_terms', $form).prop('checked')) {
            //
          } else {
            err_msg = "Please agree to the challenge rules in order to Submit.";
            isValid = false;
          }
        }
        
        if(isValid) {
          // abort any pending request
          if (request) {
            request.abort();
          }
          // let's select and cache all the fields
          var $inputs = $form.find("input, select, button, textarea");
          // serialize the data in the form
          var serializedData = $form.serialize();

          // let's disable the inputs for the duration of the ajax request
          // Note: we disable elements AFTER the form data has been serialized.
          // Disabled form elements will not be serialized.
          $inputs.prop("disabled", true);
          $('body').showLoading();
//          alert('Sending data...');

          // fire off the request to /form.php
          request = $.ajax({
            url: "https://script.google.com/macros/s/AKfycbyQYeWKn3EN2W8kR4weWZkQ3h-eqbpSOc2ypi_UnUCFKoH9yMo/exec",
            type: "post",
            data: serializedData
          });

          // callback handler that will be called on success
          request.done(function (response, textStatus, jqXHR){
            // log a message to the console
            console.log("Infromation submitted.");
            $.ajax({
              url: ajaxURL+"/submission",
              type: "post",
              data: serializedData
            }).done(function() {
              console.log("Notification emails have been sent.");
              window.location.href = siteURL+'/thank-you/';
                $('#submissionForm')[0].reset();
            });
            
          });

          // callback handler that will be called on failure
          request.fail(function (jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.error(
              "The following error occured: "+
              textStatus, errorThrown
            );
            $inputs.prop("disabled", false);
            $('body').hideLoading();
            alert("Error occured while submitting the infromation.");
          });

          // callback handler that will be called regardless
          // if the request failed or succeeded
          request.always(function () {
            // reenable the inputs
//            $inputs.prop("disabled", false);
//            $form.hideLoading();
          });
        } else {
          $('.submission-form-message').addClass('error').text(err_msg);
          scrollToElement($('.submission-form-message'), 600, -55);
        }
        return false;
      });
      
      $('#leader_bio, #member_bio_1, #member_bio_2, #member_bio_3, #member_bio_4, #member_bio_5').textcounter({type: "word", max: 81, countContainerClass: 'hidden-xs-up'});
      $('#solution_name').textcounter({max: 41, countContainerClass: 'hidden-xs-up'});
      $('#solution_description, #solution_audience, #solution_outcomes').textcounter({type: "word", max: 51, countContainerClass: 'hidden-xs-up'});
      $('#solution_equalrating, #solution_experience, #solution_differntiation, #solution_time_market, #solution_feasibility, #solution_whywin, #solution_risks').textcounter({type: "word", max: 101, countContainerClass: 'hidden-xs-up'});
      $('#solution_scalability, #solution_roadmap, #opensource_solution_info').textcounter({type: "word", max: 201, countContainerClass: 'hidden-xs-up'});
      
      if($('.add-member').length > 0) {
        $('.add-member').click(function(e) {
          e.preventDefault();
          if($('.member-info.hidden-xs-up').length > 0) {
            $('.member-info.hidden-xs-up:eq(0)').toggleClass('hidden-xs-up');
          }
          if($('.member-info.hidden-xs-up').length <= 0) {
            $(this).toggleClass('hidden-xs-up');
          }
        });
      }
      
      $('.input-file-wrapper').each(function() {
        var $uploadWrapper = $(this);
        var $input = $('input[type="file"]', $uploadWrapper);
        $input.change(function(e){
          var files = e.target.files;
          var filename = e.target.files[0].name;
          var extension = filename.replace(/^.*\./, '');
          if (extension === filename) {
            extension = '';
          } else {
            extension = extension.toLowerCase();
          }
          switch (extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
              // Create a formdata object and add the files
              var data = new FormData();
              $.each(files, function(key, value) {
                data.append(key, value);
              });
              
              $('#submissionForm').showLoading();
              $.ajax({
                url: uploadURL+'?files',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                  if(typeof data.error === 'undefined') {
                    $('#solution-assets-filename').html('<a href="'+data.files[0]+'" target="_blank">'+filename+'</a>');
                    $('#solution_assets').attr({'value':data.files[0]});
                  } else {
                    alert('ERRORS: ' + data.error);
                  }
                  $('#submissionForm').hideLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  alert('ERRORS: ' + textStatus);
                  $('#submissionForm').hideLoading();
                }
              });
            break;

            default:
              alert("PNG, JPG, or GIF file format only. Max size 2Mb (megabytes).");
          }
        });
      });
    }
    
    // Go to top button
    if($('#goTop').length > 0) {
      $('#goTop').click(function(e) {
        e.preventDefault();
        scrollToElement($('body'), 600, -55);
      });
    }
    
    $(document).bind('click touchstart', function(e) {
      var $clicked = $(e.target);
      if($('.faqs-dropdown').length > 0) {
        if($('.faqs-dropdown').hasClass('dropdown--open')) {
          if ($clicked.parents('.faqs-dropdown').length > 0 || 
            $clicked.attr('class')==='faqs-dropdown')  {
    //          Do nothing
          } else {
            $('.faqs-dropdown .dropdown-list').stop().fadeOut();
            $('.faqs-dropdown').removeClass('dropdown--open');
          }
        }
      }
    });
    
    
    $('.menu-item-has-children').each(function() {
      var $item = $(this);
      var $submenuToggle = $('<a href="#" class="submenu-toggle">');
      var $submenu = $('ul:eq(0)', $item);
      /* code for positioning toogle arrow for menu items with submenus.
       * commented becasue it will not work properly as menus is hidden on load.
       * 
       * var marginLeft = ($('a:eq(0)', $item).width()) / 2;
       * $submenuToggle.css({'margin-left': marginLeft+'px'});
       */
      
      $item.append($submenuToggle);
      $submenuToggle.click(function(e) {
        e.preventDefault();
        $item.toggleClass('expanded');
        $submenu.slideToggle();
      });
    });
    
    // Menu Toggle on small screen sizes
    $('#menu-toggle').click(function(e) {
      e.preventDefault();
      $(this).toggleClass('menu-toggle--active');
      $('.primary-menu').slideToggle();
    });
    
    
    if($('.countdown').length > 0) {
      $('.countdown').each(function() {
        var $item = $(this);
        $item.countdown($item.data('countdown-date'), function(event) {
          $(this).html(event.strftime('<div class="dtobj"><strong>%D</strong><br class="hidden-md-down" />d<span class="hidden-md-down">ays</span></div><div class="dt_colons">:</div><div class="dtobj"><strong>%H</strong><br class="hidden-md-down" />h<span class="hidden-md-down"ays</span>ours</span></div><div class="dt_colons">:</div><div class="dtobj"><strong>%M</strong><br class="hidden-md-down" />m<span class="hidden-md-down"ays</span>inutes</span></div>'));
        }).on('finish.countdown', function() {
//          console.log("Countdown finished");
        });
      });
    }
    
    
    if($('[data-bgimg]').length > 0) {
      $('[data-bgimg]').each(function() {
        bgimg = $(this).attr('data-bgimg');
        $(this).css({
          'background-image': 'url('+bgimg+')'
        });
      });
    }
    if($('[data-bgcolor]').length > 0) {
      $('[data-bgcolor]').each(function() {
        bgcolor = $(this).attr('data-bgcolor');
        $(this).css({
          'background-color': bgcolor
        });
      });
    }
    
    if($('.home-carousel').length > 0) {
      $('.home-carousel').bxSlider({
        auto: true,
        pause: 8000,
        controls: true,
        pager: true
      });
    }
    
    if($('#statistics').length > 0) {
      var $masonryPosts = $('#statistics');
      $masonryPosts.imagesLoaded( function() {
        $masonryPosts.masonry({
          itemSelector        : '.masonry-item',
          columnWidth         : '.masonry-item',
          transitionDuration  : 0
        });
      });
    }
    
    /* HOME MESSAGE SLIDER */
    if($('.section-messages-slider').length > 0) {
      $('.section-messages-slider ul').bxSlider({
        auto: true,
        controls: true,
        pager: false,
        pause: 7000,
        speed: 800
      });
    }
    
    /* FAQS */
    function toggleFaqsDropdown($container, $list) {
      if($container.hasClass('dropdown--open')) {
        $list.stop().fadeOut();
        $container.removeClass('dropdown--open');
      } else {
        $list.stop().fadeIn();
        $container.addClass('dropdown--open');
      }
    }
    
    if($('.faqs-dropdown').length > 0) {
      $('.faqs-dropdown').each(function(e) {
        var $container = $(this);
        var $header = $('.dropdown-header', $container);
        var $toggleButton = $('.dropdown-toggle', $container);
        var $list = $('.dropdown-list', $container);
        $header.click(function(e) {
          e.preventDefault();
          toggleFaqsDropdown($container, $list);
        });
        
        $toggleButton.click(function(e) {
          e.preventDefault();
          toggleFaqsDropdown($container, $list);
        });
        
        $('a', $list).each(function(e) {
          var $item = $(this);
          $item.click(function(e) {
            e.preventDefault();
            if($item.hasClass('selected')) {
              toggleFaqsDropdown($container, $list);
            } else {
              $('.selected', $list).removeClass('selected');
              $item.addClass('selected');
              toggleFaqsDropdown($container, $list);
              
              $header.text($item.text());
              faqId = $item.attr('data-id');
              scrollToElement($('.faq-item-'+faqId), 600, -30);
            }
          });
        });
      });
    }
    
    if($('.input-score-slider').length > 0) {
      $('.input-score-slider').each(function() {
        var $item = $(this);
        $item.slider();
        $item.on("change", function(slideEvt) {
          $("#"+$item.data('slider-label')).text(slideEvt.value.newValue);
          
          var total_score = parseInt($('#score_scalability').val()) + 
                  parseInt($('#score_human_centric').val()) + 
                  parseInt($('#score_differentiated').val()) + 
                  parseInt($('#score_acceleration').val()) + 
                  parseInt($('#score_team').val());
          
          $('.total-score').text(total_score);
          $('#total_score').attr('value', total_score);
          
        });
      });
    }
  } )();
} )( jQuery );


function get_hostname(url) {
  var m = ((url||'')+'').match(/^https?:\/\/[^/]+/);
  return m ? m[0] : null;
}