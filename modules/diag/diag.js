function diag_load() {

// Инициализация карты
  var svg = document.getElementById("svg");
  var map = svg.getElementById("map");
  var ul = document.getElementById("map_data");

  var count_x = axis_x_h.length;
  var count_y = axis_y_h.length;
  
  var keys = Object.keys(axis_x_data);
  var attr = axis_x_data[keys[0]];
  var count_m = (attr.length)? attr.length: 1;

// Отрисовка холста
  var chart_left = 30;
  var chart_bottom = 50;

  var chart_width  = svg.getAttribute("width") - chart_left;
  var chart_height = svg.getAttribute("height") - chart_bottom;

  var chart = document.createElementNS("http://www.w3.org/2000/svg", 'rect');
  chart.setAttribute("id","chart");
  chart.setAttribute("x", chart_left);
  chart.setAttribute("y", 1);
  chart.setAttribute("width", chart_width);
  chart.setAttribute("height", chart_height);
  map.appendChild(chart);

// Отрисовка осей
  var ax = new Array(count_y);
  var dx = Math.round(chart_width / count_x);
  var dy = Math.round(chart_height / count_y);

  for (var i=0; i < count_y; i++) {
      var x1 = chart_left - 10;
      var x2 = chart_left + chart_width;
      var y = chart_height - i*dy + 1;
      ax[i] = line(x1,y,x2,y);
      map.appendChild(ax[i]);
  }

  for (var i=0; i < count_x; i++) {
      var x = chart_left + i*dx;
      var y1 = chart_height + 1;
      var y2 = chart_height + 12;
      ax[i] = line(x,y1,x,y2);
      map.appendChild(ax[i]);
  }

  function line(x1,y1,x2,y2) {
      var ax = document.createElementNS("http://www.w3.org/2000/svg", 'line');
      ax.setAttribute("x1", x1);
      ax.setAttribute("y1", y1);
      ax.setAttribute("x2", x2);
      ax.setAttribute("y2", y2);
      return ax;
  }

// Вывод заголовков  
  var title = document.getElementById("diag_title");
  var head = document.getElementById("header");
  head.innerHTML = header;
  document.title = header;

// Вывод надписей по оси x
  var tx = new Array(count_x);
  for (var i=0; i < count_x; i++) {
      var x = chart_left + i*dx + 10;
	  var y = chart_height + 16;
	  tx[i] = document.createElementNS("http://www.w3.org/2000/svg", 'text');	  
	  tx[i].setAttribute("x",x);
	  tx[i].setAttribute("y",y);
      tx[i].innerHTML = axis_x_h[i];
	  map.appendChild(tx[i]);
  }
    
// Вывод надписей по оси y
  var ty = new Array(count_y);
  for (var i=0; i < count_y; i++) {
      var x = chart_left - 20;
	  var y = chart_height - i*dy - 3;
	  ty[i] = document.createElementNS("http://www.w3.org/2000/svg", 'text');
	  ty[i].setAttribute("x",x);
	  ty[i].setAttribute("y",y);
      ty[i].innerHTML = axis_y_h[i];
	  map.appendChild(ty[i]);
  }
  
// Отрисовка диаграммы
  var rect = new Array(count_x * count_m);
  
  var kx = 0.8; // Коэффициент ширины столбца
  var ky = dy/(axis_y_h[1] - axis_y_h[0]); // Единица высоты стоблца
  
  var i = 0;
  for (var key in axis_x_data) {
      var dat = axis_x_data[key];
      var wx = Math.round(dx * kx); // ширина стоблца
      var x = chart_left + Math.round(dx * (1 - kx) / 2) + i * dx;
	  var y = chart_height + 1;
      for (var j=0; j < count_m; j++) {
          var idx = i*count_m + j;
		  var hy = Math.round(dat[j] * ky); // высота столбца
		  y -= hy;
          rect[idx] = document.createElementNS("http://www.w3.org/2000/svg", 'rect');
          rect[idx].setAttribute("id",key + j);
		  rect[idx].setAttribute("class","dat");
          rect[idx].setAttribute("x", x);
          rect[idx].setAttribute("y", y);
          rect[idx].setAttribute("width", wx);
          rect[idx].setAttribute("height", hy);
          rect[idx].setAttribute("fill", legend_data.colors[j]);
          map.appendChild(rect[idx]);
      }
      i++;
  }
 
// Вывод легенды
  var legend = document.getElementById("legend_data");
  var legend_header = document.getElementById("legend_header");
  legend_header.innerHTML = legend_data.header;

  var legend_count = legend_data.colors.length;

  var lg = new Array(legend_count);

  for (var i=0; i < legend_count; i++) {
      lg[i] = document.createElement("li");
      var str = '<div class="bullet" style="background-color:' + legend_data.colors[i] + '"></div>';
      lg[i].innerHTML = str + legend_data.title[i];
      legend.appendChild(lg[i]);
  }

// Вывод подсказки при наведении
  map.addEventListener("mousemove",function(e) {
     if (e.target.getAttribute("class") == "dat") {
        var id = e.target.id;
        var j = id.substring(id.length-1);
        var key = id.substring(0,id.length-1);
        title.style.left = (e.pageX + 15) + 'px';
        title.style.top = (e.pageY + 25) + 'px';
        title.style.display = 'inline-block';
        title.innerHTML = legend_data.title[j] + ': ' + axis_x_data[key][j];
     }
  });

// Вывод подсказки при наведении
  map.addEventListener("mouseout",function(e) {
        title.style.display = 'none';
  });
}
