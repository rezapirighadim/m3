var icons=new Skycons({color:"#fff"}),list=["clear-day","clear-night","partly-cloudy-day","partly-cloudy-night","cloudy","rain","sleet","snow","wind","fog"],i;for(i=list.length;i--;){icons.set(list[i],list[i])}icons.play();var data=[],totalPoints=500;var updateInterval=300;var plot;var choiceContainer;var datasets;jQuery(document).ready(function(a){widget_easy_pie_chart();widget_simple_weather();widget_plot_real_time_chart();widget_plot_update();a(".switchCheckBox").bootstrapSwitch();widget_social_share();widget_color_switcher();progress_bar();flotChartStartPie();plotAccordingToChoicesDataSet();plotAccordingToChoicesToggle()});function widget_easy_pie_chart(){$(".easyPieChartFacebook").easyPieChart({barColor:$redActive,scaleColor:$redActive,easing:"easeOutBounce",onStep:function(c,b,a){$(this.el).find(".easyPiePercentFacebook").text(Math.round(a))}});$(".easyPieChartLightGreen").easyPieChart({barColor:$lightGreen,scaleColor:$lightGreen,easing:"easeOutBounce",onStep:function(c,b,a){$(this.el).find(".easyPieChartLightGreenPercent").text(Math.round(a))}});$(".easyPieChartBlack").easyPieChart({barColor:"#3F414D",scaleColor:"#3F414D",easing:"easeOutBounce",onStep:function(c,b,a){$(this.el).find(".easyPieChartBlackPercent").text(Math.round(a))}})}function widget_simple_weather(){$.simpleWeather({location:"Austin, TX",woeid:"",unit:"c",success:function(b){var a='<i class="icon-'+b.code+'"></i><h2>'+b.temp+"&deg;"+b.units.temp+"</h2>";a+="<ul><li>"+b.city+", "+b.region+"</li>";a+='<li class="currently">'+b.currently+"</li>";a+="<li>"+b.wind.direction+" "+b.wind.speed+" "+b.units.speed+"</li></ul>";$("#weather").html(a)},error:function(a){$("#weather").html("<p>"+a+"</p>")}});$.simpleWeather({location:"Dhaka, Bangladesh",woeid:"",unit:"c",success:function(b){var a='<i class="icon-'+b.code+'"></i><h2>'+b.temp+"&deg;"+b.units.temp+"</h2>";a+="<ul><li>"+b.city+", "+b.region+"</li>";a+='<li class="currently">'+b.currently+"</li>";a+="<li>"+b.wind.direction+" "+b.wind.speed+" "+b.units.speed+"</li></ul>";$("#weather2").html(a)},error:function(a){$("#weather2").html("<p>"+a+"</p>")}});$.simpleWeather({location:"Paris, Franch",woeid:"",unit:"c",success:function(b){var a='<i class="icon-'+b.code+'"></i><h2>'+b.temp+"&deg;"+b.units.temp+"</h2>";a+="<ul><li>"+b.city+", "+b.region+"</li>";a+='<li class="currently">'+b.currently+"</li>";a+="<li>"+b.wind.direction+" "+b.wind.speed+" "+b.units.speed+"</li></ul>";$("#weather3").html(a)},error:function(a){$("#weather3").html("<p>"+a+"</p>")}});$.simpleWeather({location:"London",woeid:"",unit:"c",success:function(b){var a='<i class="icon-'+b.code+'"></i><h2>'+b.temp+"&deg;"+b.units.temp+"</h2>";a+="<ul><li>"+b.city+", "+b.region+"</li>";a+='<li class="currently">'+b.currently+"</li>";a+="<li>"+b.wind.direction+" "+b.wind.speed+" "+b.units.speed+"</li></ul>";$("#weather4").html(a)},error:function(a){$("#weather4").html("<p>"+a+"</p>")}});$("#weatherfeed").weatherfeed(["UKXX0085"]);$("#weatherfeed2").weatherfeed(["BGXX0003"],{unit:"c"});$("#weatherfeed3").weatherfeed(["FRXX0076"])}function widget_plot_real_time_chart(){$("#updateInterval").val(updateInterval).change(function(){var a=$(this).val();if(a&&!isNaN(+a)){updateInterval=+a;if(updateInterval<1){updateInterval=1}else{if(updateInterval>2000){updateInterval=2000}}$(this).val(""+updateInterval)}});plot=$.plot("#realTimeChart",[getRandomData()],{series:{lines:{show:true,lineWidth:1,fill:true,fillColor:{colors:[{opacity:0.2},{opacity:0.1}]}},shadowSize:0},colors:["#1FB5AD"],yaxis:{min:0,max:150},xaxis:{show:false},grid:{tickColor:$fillColor1,borderWidth:0}})}function widget_plot_update(){plot.setData([getRandomData()]);plot.draw();setTimeout(widget_plot_update,updateInterval)}var choiceContainer;var datasets;function plotAccordingToChoicesDataSet(){datasets={a:{label:"Product A",data:[[2010,0],[2011,40],[2012,60],[2013,80],[2014,70]]},b:{label:"Product B",data:[[2010,30],[2011,45],[2012,80],[2013,75],[2014,90]]},c:{label:"Product C",data:[[2010,10],[2011,20],[2012,30],[2013,40],[2014,80]]}};var a=0;$.each(datasets,function(b,c){c.color=a;++a});choiceContainer=$("#choicesWidget");$.each(datasets,function(b,c){choiceContainer.append("<li><input class='switchCheckBox' data-size='mini' type='checkbox' name='"+b+"' checked='checked' id='id"+b+"'></input><br/><label class='switch-label' for='id"+b+"'>"+c.label+"</label></li>")});plotAccordingToChoices()}function plotAccordingToChoices(){var a=[];choiceContainer.find("input:checked").each(function(){var b=$(this).attr("name");if(b&&datasets[b]){a.push(datasets[b])}});if(a.length>0){$.plot("#seriesToggleWidget",a,{highlightColor:$lightGreen,yaxis:{min:0,show:true,color:"#E3DFD8"},xaxis:{tickDecimals:0,show:true,color:"#E3DFD8"},colors:[$lightGreen,$redActive,$lightBlueActive,$greenActive],grid:{borderColor:"#E3DFD8"}})}$(".switchCheckBox").bootstrapSwitch()}function plotAccordingToChoicesToggle(){$(".switchCheckBox").on("switchChange.bootstrapSwitch",function(a,b){plotAccordingToChoices()})}function flotChartStartPie(){var d=[],c=Math.floor(Math.random()*6)+1;
for(var b=0;b<c;b++){d[b]={label:"Product - "+(b+1),data:Math.floor(Math.random()*100)+1}}var a=$("#flotPieChart");var d=[{label:"Product - 1",data:43},{label:"Product - 2",data:19},{label:"Product - 3",data:89},{label:"Product - 4",data:83}];$.plot(a,d,{series:{pie:{show:true,radius:1,label:{show:true,radius:3/4,formatter:labelFormatter,background:{opacity:0.5,color:"#000"}}}},legend:{show:false},colors:[$fillColor2,$lightBlueActive,$redActive,$blueActive,$brownActive,$greenActive]})}function labelFormatter(a,b){return"<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>"+a+"<br/>"+Math.round(b.percent)+"%</div>"}function getRandomData(){if(data.length>0){data=data.slice(1)}while(data.length<totalPoints){var c=data.length>0?data[data.length-1]:50,d=c+Math.random()*10-5;if(d<0){d=0}else{if(d>100){d=99}}data.push(d)}var b=[];for(var a=0;a<data.length;++a){b.push([a,data[a]])}return b}function widget_social_share(){$(".social-share").mouseenter(function(){$(this).addClass("overlay-hover")}).mouseleave(function(){$(this).removeClass("overlay-hover")})}function widget_color_switcher(){var a=$("body");$(".change-color-switch ul li ").click(function(){a.removeClass("black-color");a.removeClass("blue-color");a.removeClass("deep-blue-color");a.removeClass("red-color");a.removeClass("light-green-color");a.removeClass("default");$(".change-color-switch ul li ").removeClass("active");if($(this).hasClass("active")){}else{var b=$(this).attr("class");a.addClass(b);$(this).addClass("active")}})}function progress_bar(){$(".progress-bar").progressbar({display_text:"fill"})};