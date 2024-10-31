jQuery(function($) { 
$(document).ready(function() { 

if(sessionStorage.length !== 0){	
var ohsm_menuStored = 'ohsm_req';
	for(var j = 0; j < sessionStorage.length; j++ ){   

	var ohsm_menuStored = sessionStorage.key(j).substr(11);
	
		if (sessionStorage.getItem(sessionStorage.key(j))) {
			if (document.getElementsByClassName(ohsm_menuStored)[0]) {
				
				document.getElementsByClassName(ohsm_menuStored)[0].innerHTML = sessionStorage.getItem(sessionStorage.key(j));				

			}
		}
	}
				slideByIcons();
				active_item();
				storeMenu();
} else {
		
		$('ul.ohsm_req li.ohsm-menu-item ul').hide();
		slideByIcons();
        active_item();
        storeMenu();
}	



});

function storeMenu() {
    $('li.ohsm-menu-item a').click(function(event2) {
        if (event2.target.nodeName === "A") {
            $("ul.ohsm_req").find("ul").stop(true, true);
            if ($(this).parents("ul").hasClass("ohsm_req") || $(this).parents("div").hasClass("entry-content") || $(this).parents("div").hasClass("nav-links")) {
				
				var ohsm_menu_classes = $(this).parents("ul.ohsm_req").attr('class').split(' ');
				
				for (var i = 0; i < ohsm_menu_classes.length; i++) {					
					
					if( ohsm_menu_classes[i].indexOf('ohsm_widget') !== -1 ){						
						
						menuStore = document.getElementsByClassName(ohsm_menu_classes[i])[0].innerHTML;
						menuStored = "menuStored-" + ohsm_menu_classes[i];
						sessionStorage.setItem(menuStored, menuStore);
					}
					
					
				}
                
                
				
            }
        }
    });
}

function active_item() {
    $("ul.ohsm_req li.ohsm-menu-item").find("a").each(function() {
        $(this).parent().removeClass("active");
        var currPage = window.location.toString();;
        var myHref = $(this).attr("href");
        if (currPage === myHref) {
            $(this).closest("li.ohsm-menu-item").addClass("active");
            if ($(this).parents("ul.ohsm-sub-menu").length > 0) {
                if ($(this).parents("ul.ohsm-sub-menu").css("display") === "none" || $(this).parents("ul.sub-menu").css("display") !== "none") {
                    $(this).parents("ul.ohsm-sub-menu").slideDown("slow");
                    $(this).parents("ul.ohsm-sub-menu").siblings("a").find("span#sign").removeClass("glyphicon-menu-right");
                    $(this).parents("ul.ohsm-sub-menu").siblings("a").find("span#sign").addClass("glyphicon-menu-down");
                    $(this).parents("ul.ohsm-sub-menu").siblings("a").find("span#folder").removeClass("glyphicon-folder-close");
                    $(this).parents("ul.ohsm-sub-menu").siblings("a").find("span#folder").addClass("glyphicon-folder-open");
                }
            }
        }
    });
};


function slideByIcons() {

    $('ul.ohsm_req li.ohsm-menu-item a span#icons').click(function(event) {
		
        if ($(this).parents("a").siblings().length !== 0) {
            event.preventDefault();
            if ($(this).parents("a").siblings("ul").css("display") === "block") {
                $(this).parents("a").siblings("ul").slideUp("slow");
                $(this).find('span#folder').removeClass("glyphicon-folder-open");
                $(this).find('span#folder').addClass("glyphicon-folder-close");
                $(this).find('span#sign').removeClass("glyphicon-menu-down");
                $(this).find('span#sign').addClass("glyphicon-menu-right");
            } else {
                $(this).parents("a").siblings("ul").slideDown("slow");
                $(this).parents("a").siblings("ul").css("display", "block");
                $(this).find('span#folder').removeClass("glyphicon-folder-close");
                $(this).find('span#folder').addClass("glyphicon-folder-open");
                $(this).find('span#sign').removeClass("glyphicon-menu-right");
                $(this).find('span#sign').addClass("glyphicon-menu-down");
            }
        }
    });
}

function responsive_menu_btn() {
    
    
    $('button.ohsm_navButton').click(function(){ 
    
        if($('nav.ohsm_nav').css('display') == 'none' ) {
            
            $('nav.ohsm_nav').slideDown("slow");
            
        }
        
        else {
            
             $('nav.ohsm_nav').slideUp("slow");
            
        }            
        
    });
    
}

responsive_menu_btn();

});