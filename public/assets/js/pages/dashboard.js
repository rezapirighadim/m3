jQuery(document).ready(function(b) {
    var a = b(window).width();
    if (a > 640) {
        if (!detectIE()) {
            // autoUpdateNumber()
        }
    }
    easyPeiChartWidget();
    // weatherIcon();
    socialShare();
    // vectorMapWidget();
    // flotChartStartPie();
    // plotAccordingToChoicesDataSet();
    // plotAccordingToChoicesToggle();
    // flot_real_time_chart_start();
    // flot_real_time_chart_start_update();
    // notificationCall();
    colorChanger()
});

function easyPeiChartWidget() {
    $("#pie-widget-1").easyPieChart({
        animate: 2000,
        barColor: $redActive,
        scaleColor: $redActive,
        lineWidth: 5,
        easing: "easeOutBounce",
        onStep: function(d, c, b) {
            $(this.el).find(".pie-widget-count-1").text(Math.round(b))
        }
    });
    $("#pie-widget-2").easyPieChart({
        animate: 2000,
        barColor: $lightGreen,
        scaleColor: $lightGreen,
        lineWidth: 5,
        easing: "easeOutBounce",
        onStep: function(d, c, b) {
            $(this.el).find(".pie-widget-count-2").text(Math.round(b))
        }
    });
    $("#pie-widget-3").easyPieChart({
        animate: 2000,
        barColor: $lightBlueActive,
        scaleColor: $lightBlueActive,
        easing: "easeOutBounce",
        lineWidth: 5,
        onStep: function(d, c, b) {
            $(this.el).find(".pie-widget-count-3").text(Math.round(b))
        }
    });
    $("#pie-widget-4").easyPieChart({
        animate: 2000,
        barColor: $success,
        scaleColor: $success,
        easing: "easeOutBounce",
        lineWidth: 5,
        onStep: function(d, c, b) {
            $(this.el).find(".pie-widget-count-4").text(Math.round(b))
        }
    });
    var a = $(window).width();
    // if (a > 640) {
    //     setInterval(function() {
    //         var b = getRandomNumber();
    //         $("#pie-widget-1").data("easyPieChart").update(b);
    //         var b = getRandomNumber();
    //         $("#pie-widget-2").data("easyPieChart").update(b);
    //         var b = getRandomNumber();
    //         $("#pie-widget-3").data("easyPieChart").update(b);
    //         var b = getRandomNumber();
    //         $("#pie-widget-4").data("easyPieChart").update(b)
    //     }, 10000)
    // }
}

function getRandomNumber() {
    var a = 1 + Math.floor(Math.random() * 100);
    return a
}

function weatherIcon() {
    var b = new Skycons({
            color: "#fff"
        }),
        c = ["clear-day", "clear-night", "partly-cloudy-day", "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind", "fog"],
        a;
    for (a = c.length; a--;) {
        b.set(c[a], c[a])
    }
    b.play()
}

function socialShare() {
    $(".social-share").mouseenter(function() {
        $(this).addClass("overlay-hover")
    }).mouseleave(function() {
        $(this).removeClass("overlay-hover")
    })
}

// function vectorMapWidget() {
//     var b = "#fff";
//     var e = $lightGreen;
//     var c = "#58595B";
//     var a = $isOnline;
//     var d = $isOnline;
//     $("#world_map").vectorMap({
//         map: "world_mill_en",
//         normalizeFunction: "polynomial",
//         backgroundColor: b,
//         regionStyle: {
//             initial: {
//                 fill: e
//             },
//             hover: {
//                 fill: c
//             }
//         },
//         markerStyle: {
//             initial: {
//                 fill: a,
//                 stroke: d,
//                 r: 4
//             },
//             hover: {
//                 stroke: "#f2f2f2",
//                 "stroke-width": 1
//             }
//         },
//         markers: [{
//             latLng: [23.78, 90.419],
//             name: "Dhaka, Bangladesh"
//         }, {
//             latLng: [40.71, -74],
//             name: "New York"
//         }, {
//             latLng: [34.05, -118.24],
//             name: "Los Angeles",
//             style: {
//                 fill: $isBusy,
//                 stroke: "none"
//             }
//         }, {
//             latLng: [41.87, -87.62],
//             name: "Chicago",
//             style: {
//                 fill: $isBusy,
//                 stroke: "none"
//             }
//         }, {
//             latLng: [29.76, -95.36],
//             name: "Houston"
//         }, {
//             latLng: [39.95, -75.16],
//             name: "Philadelphia"
//         }, {
//             latLng: [38.9, -77.03],
//             name: "Washington"
//         }, {
//             latLng: [37.36, -122.03],
//             name: "Silicon Valley"
//         }, {
//             latLng: [41.9, 12.45],
//             name: "Vatican City"
//         }, {
//             latLng: [43.73, 7.41],
//             name: "Monaco"
//         }, {
//             latLng: [-0.52, 166.93],
//             name: "Nauru"
//         }, {
//             latLng: [-8.51, 179.21],
//             name: "Tuvalu"
//         }, {
//             latLng: [43.93, 12.46],
//             name: "San Marino"
//         }, {
//             latLng: [47.14, 9.52],
//             name: "Liechtenstein",
//             style: {
//                 fill: $isBusy,
//                 stroke: "none"
//             }
//         }, {
//             latLng: [7.11, 171.06],
//             name: "Marshall Islands"
//         }, {
//             latLng: [17.3, -62.73],
//             name: "Saint Kitts and Nevis"
//         }, {
//             latLng: [3.2, 73.22],
//             name: "Maldives"
//         }, {
//             latLng: [35.88, 14.5],
//             name: "Malta"
//         }, {
//             latLng: [12.05, -61.75],
//             name: "Grenada"
//         }, {
//             latLng: [13.16, -61.23],
//             name: "Saint Vincent and the Grenadines"
//         }, {
//             latLng: [13.16, -59.55],
//             name: "Barbados"
//         }, {
//             latLng: [17.11, -61.85],
//             name: "Antigua and Barbuda"
//         }, {
//             latLng: [-4.61, 55.45],
//             name: "Seychelles"
//         }, {
//             latLng: [7.35, 134.46],
//             name: "Palau"
//         }, {
//             latLng: [42.5, 1.51],
//             name: "Andorra"
//         }, {
//             latLng: [14.01, -60.98],
//             name: "Saint Lucia"
//         }, {
//             latLng: [6.91, 158.18],
//             name: "Federated States of Micronesia"
//         }, {
//             latLng: [1.3, 103.8],
//             name: "Singapore"
//         }, {
//             latLng: [1.46, 173.03],
//             name: "Kiribati"
//         }, {
//             latLng: [-21.13, -175.2],
//             name: "Tonga",
//             style: {
//                 fill: $isIdle,
//                 stroke: "none"
//             }
//         }, {
//             latLng: [15.3, -61.38],
//             name: "Dominica"
//         }, {
//             latLng: [-20.2, 57.5],
//             name: "Mauritius"
//         }, {
//             latLng: [26.02, 50.55],
//             name: "Bahrain",
//             style: {
//                 fill: $isIdle,
//                 stroke: "none"
//             }
//         }, {
//             latLng: [19.082, 72.881],
//             name: "Mumbai,  India",
//             style: {
//                 fill: $isOffline,
//                 stroke: "none"
//             }
//         }, {
//             latLng: [55.749, 37.632],
//             name: "Russia, Moscow",
//             style: {
//                 fill: $isBusy,
//                 stroke: "none"
//             }
//         }, {
//             latLng: [51.629, -69.259],
//             name: "Rio Gallegos, Argentina"
//         }]
//     })
// }

function flotChartStartPie() {
    var d = [],
        c = Math.floor(Math.random() * 6) + 1;
    for (var b = 0; b < c; b++) {
        d[b] = {
            label: "Product - " + (b + 1),
            data: Math.floor(Math.random() * 100) + 1
        }
    }
    var a = $("#flotPieChart");
    var d = [{
        label: "Product - 1",
        data: 43
    }, {
        label: "Product - 2",
        data: 19
    }, {
        label: "Product - 3",
        data: 89
    }, {
        label: "Product - 4",
        data: 83
    }];
    $.plot(a, d, {
        series: {
            pie: {
                show: true,
                radius: 1,
                label: {
                    show: true,
                    radius: 3 / 4,
                    formatter: labelFormatter,
                    background: {
                        opacity: 0.5,
                        color: "#000"
                    }
                }
            }
        },
        legend: {
            show: false
        },
        colors: [$fillColor2, $lightBlueActive, $redActive, $blueActive, $brownActive, $greenActive]
    })
}

function labelFormatter(a, b) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + a + "<br/>" + Math.round(b.percent) + "%</div>"
}

function colorChanger() {
    var a = $("body");
    $(".change-color-switch ul li ").click(function() {
        a.removeClass("black-color");
        a.removeClass("blue-color");
        a.removeClass("deep-blue-color");
        a.removeClass("red-color");
        a.removeClass("light-green-color");
        a.removeClass("default");
        $(".change-color-switch ul li ").removeClass("active");
        if ($(this).hasClass("active")) {} else {
            var b = $(this).attr("class");
            a.addClass(b);
            $(this).addClass("active")
        }
    })
}

function notificationCall() {
    $.amaran({
        content: {
            message: "ایمیل جدید وارد شده",
            size: "۴ ایمیل جدید در صندوق پستی",
            file: "",
            icon: "fa fa-envelope-o"
        },
        theme: "default ok",
        position: "bottom right",
        inEffect: "slideRight",
        outEffect: "slideBottom",
        closeButton: true,
        delay: 5000
    });
    setTimeout(function() {
        $.amaran({
            content: {
                img: "assets/images/userimage/avatar3-80.png",
                user: " پیام چت جدید",
                message: 'سلام! چطوری ؟ لطفا به من دست بزنید زمانی که شما وارد شدید <i class="fa fa-smile-o"></i>'
            },
            theme: "user",
            position: "bottom left",
            inEffect: "slideRight",
            outEffect: "slideBottom",
            closeButton: true,
            delay: 5000
        });
        setTimeout(function() {
            $.amaran({
                content: {
                    message: "نمی توان این محصول را دریافت کرد",
                    size: "۳۲ Kg",
                    file: "H: ۳۲ جاده: ۲۱, شیکاگو, NY ۳۲۱۰",
                    icon: "fa fa fa-truck"
                },
                theme: "default error",
                position: "top right",
                inEffect: "slideRight",
                outEffect: "slideTop",
                closeButton: true,
                delay: 5000
            })
        }, 5000)
    }, 5000)
}

// function autoUpdateNumber() {
//     var c = {
//         useEasing: true,
//         useGrouping: true,
//         separator: ",",
//         decimal: "."
//     };
//     var f = new countUp("product-up", 0, 39, 0, 9.5, c);
//     f.start();
//     var b = new countUp("income-show", 0, 10299.3, 2, 9.5, c);
//     b.start();
//     var d = new countUp("user-show", 0, 132129, 0, 5.5, c);
//     d.start();
//     var g = new countUp("deliver-show", 0, 10490, 1, 6.5, c);
//     g.start();
//     var e = new countUp("download-show", 0, 5340, 0, 9.5, c);
//     e.start();
//     var a = new countUp("sale-view", 0, 2129, 0, 9.5, c);
//     a.start()
// }
var data = [],
    totalPoints = 500;
//
// function getRandomData() {
//     if (data.length > 0) {
//         data = data.slice(1)
//     }
//     while (data.length < totalPoints) {
//         var c = data.length > 0 ? data[data.length - 1] : 50,
//             d = c + Math.random() * 10 - 5;
//         if (d < 0) {
//             d = 0
//         } else {
//             if (d > 100) {
//                 d = 99
//             }
//         }
//         data.push(d)
//     }
//     var b = [];
//     for (var a = 0; a < data.length; ++a) {
//         b.push([a, data[a]])
//     }
//     return b
// }
var plot;

function flot_real_time_chart_start() {
    plot = $.plot("#realTimeChart", [getRandomData()], {
        series: {
            lines: {
                show: true,
                lineWidth: 1,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.2
                    }, {
                        opacity: 0.1
                    }]
                }
            },
            shadowSize: 0
        },
        colors: ["#1FB5AD"],
        yaxis: {
            min: 0,
            max: 150
        },
        xaxis: {
            show: false
        },
        grid: {
            tickColor: $fillColor1,
            borderWidth: 0
        }
    })
}

function flot_real_time_chart_start_update() {
    var a = 300;
    plot.setData([getRandomData()]);
    plot.draw();
    setTimeout(flot_real_time_chart_start_update, a)
}
var choiceContainer;
var datasets;

function plotAccordingToChoicesDataSet() {
    datasets = {
        a: {
            label: "Product A",
            data: [
                [2010, 0],
                [2011, 40],
                [2012, 60],
                [2013, 80],
                [2014, 70]
            ]
        },
        b: {
            label: "Product B",
            data: [
                [2010, 30],
                [2011, 45],
                [2012, 80],
                [2013, 75],
                [2014, 90]
            ]
        },
        c: {
            label: "Product C",
            data: [
                [2010, 10],
                [2011, 20],
                [2012, 30],
                [2013, 40],
                [2014, 80]
            ]
        }
    };
    var a = 0;
    $.each(datasets, function(b, c) {
        c.color = a;
        ++a
    });
    choiceContainer = $("#choicesWidget");
    $.each(datasets, function(b, c) {
        choiceContainer.append("<li><input class='switchCheckBox' data-size='mini' type='checkbox' name='" + b + "' checked='checked' id='id" + b + "'></input><br/><label class='switch-label' for='id" + b + "'>" + c.label + "</label></li>")
    });
    plotAccordingToChoices()
}

function plotAccordingToChoices() {
    var a = [];
    choiceContainer.find("input:checked").each(function() {
        var b = $(this).attr("name");
        if (b && datasets[b]) {
            a.push(datasets[b])
        }
    });
    if (a.length > 0) {
        $.plot("#seriesToggleWidget", a, {
            highlightColor: $lightGreen,
            yaxis: {
                min: 0,
                show: true,
                color: "#E3DFD8"
            },
            xaxis: {
                tickDecimals: 0,
                show: true,
                color: "#E3DFD8"
            },
            colors: [$lightGreen, $redActive, $lightBlueActive, $greenActive],
            grid: {
                borderColor: "#E3DFD8"
            }
        })
    }
    $(".switchCheckBox").bootstrapSwitch()
}

function plotAccordingToChoicesToggle() {
    $(".switchCheckBox").on("switchChange.bootstrapSwitch", function(a, b) {
        plotAccordingToChoices()
    })
};

//$(".mainNav li a").filter(function(){
//        return this.href == location.href.replace(/#.*/, "");
//    })
//    .addClass("active")
//    .closest('ul')
//    .prev('a')
//    .addClass("active");


