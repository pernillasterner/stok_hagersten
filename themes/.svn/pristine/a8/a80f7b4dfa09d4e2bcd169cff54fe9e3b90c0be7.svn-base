	    <div id="date" class="pie"></div>

	    <script type=""text/javascript>
		$(function() {
	<?php 
					
				    print ('var highlightedDays = ["'. implode('","',$aveny->get_event_dates()).'"]');
	
	?>
		//    var highlightedDays = ["2012-09-01","2012-09-15","2012-09-03","2012-09-27"];
			
			var secondDaysbla = [];
			for ( var i = 0, il = highlightedDays.length; i < il; i++ ) {
				var str = highlightedDays[i];
				var s = str.split("-");
				s[0] = +s[0];
				s[1] = +s[1];
				s[2] = +s[2];
				var tmpdate = new Date(s[0], s[1]-1, s[2]).getTime();
				secondDaysbla.push(tmpdate);
			} 

			var padder = function( num ) {
				if ( num < 10 && num.length < 2 ) return "0" + num;
			};
		    
		    $( "#date" ).datepicker({
			dateFormat: "yy-mm-dd",
			monthNames: ["Januari","Februari","Mars","April","Maj","Juni","Juli","Augusti","September","Oktober","November","December"],
			dayNamesMin: ["Sö", "Må", "Ti", "On", "To", "Fr", "Lö"],
			showWeek: true,
			weekHeader: "V.",
			firstDay: 1,
			prevText: "◄",
			nextText: "►",
			onSelect: function(value, date) { 
			    document.location.href = '/kalender/dagvy?kal='+value;
			},


			beforeShowDay: function(date) {
			    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
			    for (var i = 0, il = secondDaysbla.length; i < il; i++) {
					if (date.getTime() === secondDaysbla[i]) {
						return [true, 'ui-state-active-td', ''];
					}
			    }
			    return [true];

			}
			
/*
			beforeShowDay: function(date) {
			    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
			    for (i = 0; i < highlightedDays.length; i++) {
				if($.inArray(y + '-' + (m+1) + '-' + d,highlightedDays) != -1) {
				    //return [false];
				    return [true, 'ui-state-active-td', ''];
				}
			    }
			    return [true];

			}
*/			
		    });

		    
		    
		    
		    
		    $('.ui-datepicker-week-col').each(function(){
			    var week = $(this).html();
			    var year = $('.ui-datepicker-year').html();
			    
			    if($(this).html() == 'V.'){
				
				// Do nothing to this table-cell
				
			    }
			   
			    else{
				
				// Add link to these table-cells
				
				$(this).html('<a href="/kalender/?kal='+year+-+week+'">'+week+'</a>');

				
			    }
			
		    });
		    
		    
		    $('.ui-datepicker-next').live("click", function(){
			     
			$('.ui-datepicker-week-col').each(function(){
				var week = $(this).html();
				var year = $('.ui-datepicker-year').html();
				
				if($(this).html() == 'V.'){

				    // Do nothing to this table-cell

				}

				else{

				    // Add link to these table-cells
				    $(this).html('<a href="/kalender/?kal='+year+-+week+'">'+week+'</a>');

				}

			});
			
		    });
		    
		    $('.ui-datepicker-prev').live("click", function(){
			     
			$('.ui-datepicker-week-col').each(function(){
				var week = $(this).html();
				var year = $('.ui-datepicker-year').html();
				
				if($(this).html() == 'V.'){

				    // Do nothing to this table-cell

				}

				else{

				    // Add link to these table-cells
				    $(this).html('<a href="/kalender/?kal='+year+-+week+'">'+week+'</a>');

				}

			});
			
		    });
			
		});
		</script>

		
		<nav class="sub-menu before-share pie">
					
		    <ul>
		    <li><a href="/kalender/dag">Dagens händelser</a></li>
		    <li><a href="/kalender">Veckans händelser</a></li>
		    </ul>
					
		</nav>