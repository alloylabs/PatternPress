$(document).on('shown.bs.dropdown', function(event) {
    var dropdown = $(event.target);
    
    // Set aria-expanded to true
    dropdown.find('.dropdown-menu').attr('aria-expanded', true);
    
    // Set focus on the first link in the dropdown
    setTimeout(function() {
        dropdown.find('.dropdown-menu.picker-menu li:first-child a').focus();
    }, 10);
});

// On dropdown close
$(document).on('hidden.bs.dropdown', function(event) {
    var dropdown = $(event.target);
    
    // Set aria-expanded to false        
    dropdown.find('.dropdown-menu').attr('aria-expanded', false);
    
    // Set focus back to dropdown toggle
    dropdown.find('.dropdown-toggle').focus();
});

//make any dropdown with a picker class add the selected value to a hidden field
$( document ).on( 'click', '.picker .dropdown-menu li', function( event ) {
    var $target = $( event.target );
    $target.siblings().removeClass( 'active' );
    $target.addClass( 'active' );
    $target.closest( '.btn-group' ).find( '[data-bind="label"]' ).html( $target.html() );
    $target.closest( '.btn-group' ).find( '[type="hidden"]' ).val( $target.attr('data-bind') );
    $target.closest( '.btn-group' ).find( '.active' ).val( $target.attr('data-bind') ); 
    $target.closest( '.btn-group' ).find( '.dropdown-toggle' ).dropdown( 'toggle');
    return false; 
});


//display selected tab in mobile tab navbar
$( document ).on( 'click', '.navbar-tabs .navbar-collapse.collapse li a', function() {
    var $target = $( event.target );
    $target.closest( '.navbar' ).find( '#current-nav-page' ).text( $target.text() );
    $target.closest( '.navbar' ).find( '.navbar-collapse' ).collapse('hide');
});





//sidebar
    $( document ).on( 'click', '#nav-toggle', function() {
        if($('#sidebar').css("margin-left") == "0px"){
            $('#sidebar').animate({marginLeft:"-320px"}, 500 );
        } else if($('#sidebar').css("margin-left") == "-320px") {
            $('#sidebar').animate({marginLeft:"0px"}, 500 );
        } else {

        }
    }); 
   $( window ).resize(function() {
        sidebarOffset = $('#sidebar').offset();
        if($(window).width() > 768 && sidebarOffset.left != 0){
            $('#sidebar').css("margin-left","0");
        } 
    });

//mobileToggler
$( document ).on( 'click', '#mobile-toggler', function() {
        if($('#mobile').prop("checked")){
            $('.flex-frame').animate({width:"320px"}, 500 );
            $('#pattern-wrap').animate({height:'568px'}, 500 );
        } else {
            $('.flex-frame').animate({width:"100%"}, 500 );
            $('#pattern-wrap').animate({height:$('#pattern-wrap').attr('data-preview-height')+'px'}, 500 );
        }
    }); 