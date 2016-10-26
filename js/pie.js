onload=function pie_load() {

// Инициализация диаграммы
    var json_data = document.getElementById("pie_canvas").attributes['data'].value;
    var data = JSON.parse(json_data);
  var svg = document.getElementById("svg");
  var map = svg.getElementById("map");
  var ul = document.getElementById("map_data");
  var cx = svg.getAttribute("width") / 2;
  var radius = cx - 5;

    var pie_data = data['pie_data'];
  var count_sheet = Object.keys(pie_data).length;
  var pie = new Array(count_sheet);
  var li = new Array(count_sheet);
  var per = new Array(count_sheet);

  var sum = 0;
  for (var key in pie_data) {
      sum += parseInt(pie_data[key]);
  }
  var a = i = 0;
    var legend_data = data['legend_data'];
// Отрисовка диаграммы
    var pieRect = svg.getBoundingClientRect();
  for (var key in pie_data) {
      pie[i] = document.createElementNS("http://www.w3.org/2000/svg", 'path');
      var d = Math.round(pie_data[key] * 360/sum);
      per[key] = fric(d);
     
      var a1 = (a - 90) * Math.PI / 180;
      var a2 = (a + d - 90) * Math.PI / 180;
      var at = (a1 + a2) / 2;
      a += d;
      var x1 = Math.round(radius * Math.cos(a1));
      var y1 = Math.round(radius * Math.sin(a1));
      var x2 = Math.round(radius * Math.cos(a2)) - x1;
      var y2 = Math.round(radius * Math.sin(a2)) - y1;
      var xt = Math.round((radius - 30) * Math.cos(at));
      var yt = Math.round((radius - 30) * Math.sin(at));
      var rx = ry = radius;
      var k = ['m',cx,cx,'l',x1,y1,'a',rx,ry,0,0,1,x2,y2,'z'];
      var str = k.join(" ");
      pie[i].setAttribute("d",str);
      pie[i].setAttribute("id",key);
      pie[i].setAttribute("fill", legend_data.colors[i]);
      map.appendChild(pie[i]);

// Вывод приведенных данных
      if(pie_data[key] != 0){
          li[i] = document.createElement("li");
          li[i].setAttribute("id","t_" + key);
          li[i].style.left = cx + pieRect.left - 10 + xt + 'px';
          li[i].style.top = cx + pieRect.top + 35 + yt + 'px';
          li[i].innerHTML = per[key] + '%';
          ul.appendChild(li[i]);
      }
      i++;
  }

// Функция округления до 2 значащих цифр
  function fric(num) {
     var avr = 3.6;
     var res = (num > 10 * avr)? Math.round(num/avr):
               (num > avr)?      Math.round(num * 10/avr) / 10:
               Math.round(num * 100/avr) / 100;
     return res;
  }

// Вывод заголовков
    var header = data['header'];
  var title = document.getElementById("pie_title");
  var head = document.getElementById("header");
  head.innerHTML = header;
  document.title = header;

// Вывод легенды
  var legend = document.getElementById("legend_data");
  var legend_header = document.getElementById("legend_header");
  legend_header.innerHTML = legend_data.header;

  var li = new Array(count_sheet);
  var sh = new Array(count_sheet);

  for (var i=0; i < count_sheet; i++) {
      li[i] = document.createElement("li");
      var str = '<div class="bullet" style="background-color:' + legend_data.colors[i] + '"></div>';
      li[i].innerHTML = str + legend_data.title[i];
      legend.appendChild(li[i]);
  }

// Вывод подсказки при наведении
  map.addEventListener("mousemove",helperin);
  ul.addEventListener("mousemove",helperin);

    var pie_title = data['pie_title'];
  function helperin(e) {
     var target = e.target.id;
     var key = (target.substring(0,2) == "t_")? target.substring(2): target;
     title.style.display = "inline-block";
     title.style.left = (e.pageX + 15) + 'px';
     title.style.top = (e.pageY + 25) + 'px';
     title.innerHTML = pie_title[key]  + ": " + pie_data[key] + " (" + per[key] + "%)";
  }

    

// Восстановление стиля
  map.addEventListener("mouseout",helperout);
  ul.addEventListener("mouseout",helperout);

  function helperout(e) {
     title.style.display = "none";
  }

}
