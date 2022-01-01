(function($) {
    'use strict';
  
    $.fn.datasort = function(options) {
      var defaults = {
          //set the default parameter values
          datatype: 'alpha', //sort by letter or number
          sortElement: false,
          sortAttr: false,
          reverse: false
        },
        // combine the default and user's parameters, overriding defaults
        settings = $.extend({}, defaults, options),
        datatypes = {
          alpha: function(a, b) {
            var o = base.extract(a, b);
            return base.alpha(o.a, o.b);
          },
          number: function(a, b) {
            var o = base.extract(a, b);
            for (var e in o) {
              o[e] = o[e].replace(/[$]?(-?\d+.?\d+)/, '\$1');
            }
            return base.number(o.a, o.b);
          }
        },
        base = {
          alpha: function(a, b) {
            a = a.toUpperCase();
            b = b.toUpperCase();
            //ternary operator: condition ? returnIfTrue : returnIfFalse
            //return (a < b) ? -1 : (a > b) : 1 : 0;
  
            if (a < b) {
              return -1;
            } else if (a > b) {
              return 1;
            } else {
              return 0;
            }
          },
          number: function(a, b) {
            a = parseFloat(a);
            b = parseFloat(b);
            return a - b;
          },
          extract: function(a, b) {
            var get = function(i) {
              var o = $(i);
              if (settings.sortElement) {
                o = o.children(settings.sortElement);
              }
              if (settings.sortAttr) {
                o = o.attr(settings.sortAttr);
              } else {
                o = o.text();
              }
              return o;
            };
            return {
              a: get(a),
              b: get(b)
            };
          }
        },
        that = this;
  
      if (typeof settings.datatype === 'string') {
        that.sort(datatypes[settings.datatype]);
      }
      if (typeof settings.datatype === 'function') {
        that.sort(settings.datatype);
      }
      if (settings.reverse) {
        that = $($.makeArray(this).reverse());
      }
  
      // run plugin
      $.each(that, function(index, element) {
        that.parent().append(element);
      });
    };
  })(jQuery);
  
  // Kick off the Load More functionality
//   $(".all-events").loadmore({
//     itemsPerPage: 9,
//     itemClass: ".event-container",
//   });

  // Button click handler
  $("#branch-sort").click(function(event) {
    // get the hidden input that has regular or reverse order
    var initialOrder = $("#NameSortOrder").val();
  
    if (initialOrder == "AtoZ") {
      $(".all-events .event-container").datasort({
        datatype: 'alpha',
        sortAttr: 'data-branch-name',
        reverse: true
      });
  
      //update hidden input and change icon
      $("#NameSortOrder").val("ZtoA");
      $("#branch-sort-icon").addClass("fa-chevron-up up-xs").removeClass("fa-chevron-down");
    } 
    else {
      $(".all-events .event-container").datasort({
        datatype: 'alpha',
        sortAttr: 'data-branch-name',
        reverse: false
      });
  
      //update hidden input and change icon
      $("#NameSortOrder").val("AtoZ");
      $("#branch-sort-icon").removeClass("fa-chevron-up up-xs").addClass("fa-chevron-down");
    }
    //show the same number of results that they were seeing before the sort
    //first: get the number showing before the load more re-runs
    var numNowShowing = parseInt( $("#js-sort-numberShowing").val() );
    //second: re-start the loadmore
    // $(".all-events").loadmore({
    //   itemsPerPage: 9,
    //   itemClass: ".event-container",
    // });
    //third: show the original number of items
    for (var i = 0; i <= numNowShowing; i++) {
      $($(".event-container")).eq(i).removeClass("hide");
    }
  
    //fourth: update the number showing text
    $(".js-end-item").text(numNowShowing);
  
    //last: update the number showing hidden input value
    $("#js-sort-numberShowing").val(numNowShowing);
  
  });

  ///price
  $("#price-sort").click(function(event) {

    var initialOrder = $("#PriceSortOrder").val();
  
    if (initialOrder == "AtoZ") {
      $(".all-events .event-container").datasort({
        datatype: 'number',
        sortAttr: 'data-branch-price',
        reverse: true
      });
      $("#PriceSortOrder").val("ZtoA");
      $("#price-sort-icon").addClass("fa-chevron-up up-xs").removeClass("fa-chevron-down");
    } 
    else {
      $(".all-events .event-container").datasort({
        datatype: 'number',
        sortAttr: 'data-branch-price',
        reverse: false
      });
      $("#PriceSortOrder").val("AtoZ");
      $("#price-sort-icon").removeClass("fa-chevron-up up-xs").addClass("fa-chevron-down");
    }
    var numNowShowing = parseInt( $("#js-sort-numberShowing").val() );
    $(".all-events").loadmore({
      itemsPerPage: 9,
      itemClass: ".event-container",
    });
    for (var i = 0; i <= numNowShowing; i++) {
      $($(".event-container")).eq(i).removeClass("hide");
    }
    $(".js-end-item").text(numNowShowing);
    $("#js-sort-numberShowing").val(numNowShowing);
  
  });

  //Begins at
  $("#begins-sort").click(function(event) {

    var initialOrder = $("#BeginsSortOrder").val();
  
    if (initialOrder == "AtoZ") {
      $(".all-events .event-container").datasort({
        datatype: 'number',
        sortAttr: 'data-branch-begins',
        reverse: true
      });
      $("#BeginsSortOrder").val("ZtoA");
      $("#begins-sort-icon").addClass("fa-chevron-up up-xs").removeClass("fa-chevron-down");
    } 
    else {
      $(".all-events .event-container").datasort({
        datatype: 'number',
        sortAttr: 'data-branch-begins',
        reverse: false
      });
      $("#BeginsSortOrder").val("AtoZ");
      $("#begins-sort-icon").removeClass("fa-chevron-up up-xs").addClass("fa-chevron-down");
    }
    var numNowShowing = parseInt( $("#js-sort-numberShowing").val() );
    $(".all-events").loadmore({
      itemsPerPage: 9,
      itemClass: ".event-container",
    });
    for (var i = 0; i <= numNowShowing; i++) {
      $($(".event-container")).eq(i).removeClass("hide");
    }
    $(".js-end-item").text(numNowShowing);
    $("#js-sort-numberShowing").val(numNowShowing);
  
  });