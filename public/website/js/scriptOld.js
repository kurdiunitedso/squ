// var btn = document.querySelector(".search");
// var menu = document.querySelector(".search-div");

// btn.addEventListener("click", function () {
//     console.log("hh");
//     menu.style.display = menu.style.display === "none" ? "block" : "none";
//     return 1;
// });

// var bt = document.querySelector(".search2");
// var men = document.querySelector(".search-div2");

// bt.addEventListener("click", function () {
//     men.style.display = men.style.display === "none" ? "block" : "none";
// });

// var nav = document.querySelector(".list");
// var dn = document.querySelector(".list1");

// nav.addEventListener("click", function () {
//     dn.style.display = dn.style.display === "none" ? "block" : "none";
// });

// var list = document.querySelector(".a-lnk");
// var down = document.querySelector(".down-list");

// list.addEventListener("click", function () {
//     down.classList.toggle("show");
// });

// var dslst = document.querySelector(".a-lnk2");
// var dow = document.querySelector(".down-list2");

// dslst.addEventListener("click", function () {
//     dow.classList.toggle("show");
// });

// var dsls = document.querySelector(".a-lnk3");
// var dol = document.querySelector(".down-list3");

// dsls.addEventListener("click", function () {
//     dol.classList.toggle("show");
// });

// var dsl = document.querySelector(".a-lnk4");
// var dom = document.querySelector(".down-list4");

// dsl.addEventListener("click", function () {
//     dom.classList.toggle("show");
// });

// var add = (document.querySelector(".search").onclick = () =>
//     (document.querySelector(".search-div").style.display = "block"));

// var add = (document.querySelector(".cancl").onclick = () =>
//     (document.querySelector(".search-div").style.display = "none"));

// var add = (document.querySelector(".search2").onclick = () =>
//     (document.querySelector(".search-div2").style.display = "block"));

// var add = (document.querySelector(".cancl2").onclick = () =>
//     (document.querySelector(".search-div2").style.display = "none"));

// const swiper = new Swiper(".swiper", {
//     loop: true,

//     pagination: {
//         el: ".swiper-pagination",
//     },

//     navigation: {
//         nextEl: ".swiper-button-next",
//         prevEl: ".swiper-button-prev",
//     },
// });

// var root = am5.Root.new("chartdiv");
// root.setThemes([am5themes_Animated.new(root)]);
// var chart = root.container.children.push(
//     am5xy.XYChart.new(root, {
//         panX: false,
//         panY: false,
//     })
// );

// var cursor = chart.set(
//     "cursor",
//     am5xy.XYCursor.new(root, {
//         behavior: "zoomX",
//     })
// );
// cursor.lineY.set("visible", false);

// var date = new Date();
// date.setHours(0, 0, 0, 0);
// var value = 100;

// function generateData() {
//     value = Math.round(Math.random() * 10 - 5 + value);
//     am5.time.add(date, "day", 1);
//     return {
//         date: date.getTime(),
//         value: value,
//     };
// }

// function generateDatas(count) {
//     var data = [];
//     for (var i = 0; i < count; ++i) {
//         data.push(generateData());
//     }
//     return data;
// }

// var xAxis = chart.xAxes.push(
//     am5xy.DateAxis.new(root, {
//         maxDeviation: 0,
//         baseInterval: {
//             timeUnit: "day",
//             count: 1,
//         },
//         renderer: am5xy.AxisRendererX.new(root, {
//             minGridDistance: 60,
//         }),
//         tooltip: am5.Tooltip.new(root, {}),
//     })
// );

// var yAxis = chart.yAxes.push(
//     am5xy.ValueAxis.new(root, {
//         renderer: am5xy.AxisRendererY.new(root, {}),
//     })
// );

// var series = chart.series.push(
//     am5xy.ColumnSeries.new(root, {
//         name: "Series",
//         xAxis: xAxis,
//         yAxis: yAxis,
//         valueYField: "value",
//         valueXField: "date",
//         tooltip: am5.Tooltip.new(root, {
//             labelText: "{valueY}",
//         }),
//     })
// );

// series.columns.template.setAll({ strokeOpacity: 0 });
// chart.set(
//     "scrollbarX",
//     am5.Scrollbar.new(root, {
//         orientation: "horizontal",
//     })
// );

// var data = generateDatas(50);
// series.data.setAll(data);

// series.appear(1000);
// chart.appear(1000, 100);
// chart.chartContainer.wheelable = false;
// chart.seriesContainer.draggable = false;
// chart.seriesContainer.resizable = false;
