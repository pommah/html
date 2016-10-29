function svg_ready(emb) {

// Инициализация карты и 

  svg = emb.contentDocument;

  var map = svg.getElementById("map");
  var title = document.getElementById("map_title");
  var legend = document.getElementById("legend_data");
  var head = document.getElementById("header");
  head.innerHTML = header;
  document.title = header;

  var legend_header = document.getElementById("legend_header");
  legend_header.innerHTML = legend_data.header;

  var count_sheet = legend_data.colors.length;
  var li = new Array(count_sheet);
  var sh = new Array(count_sheet);

  for (var i=0; i < count_sheet; i++) {
      li[i] = document.createElement("li");
      var str = '<div class="bullet" style="background-color:' + legend_data.colors[i] + '"></div>';
      li[i].innerHTML = str + legend_data.title[i];
      legend.appendChild(li[i]);
  }

// Первоначальная раскраска регионов
  var regions = map.getElementsByClassName("region");
  var summa = 0;

  for (var i=0; i < regions.length; i++) {
      var id = regions[i].id;
      regions[i].style.fill = getColor(region_data[id]);
      summa += region_data[id];
  }
  
  function getColor(data) {
      var color;
      for (var j=0; j < legend_data.data.length - 1; j++) {
          if ((data >= legend_data.data[j]) && (data <= legend_data.data[j+1])) {
             color = legend_data.colors[j];
          }
      }
      return color;
  }

  var rev = 0;

// Задание поведения выделения (округа/регионы)
  var rev_type = ["federal", "regions"];
  var sel_type = ["feder", "region"];

  document.form1.filter[0].addEventListener("click",getfilter);
  document.form1.filter[1].addEventListener("click",getfilter);

  function getfilter(e) {
      rev = e.target.value;
      map.setAttribute("class",rev_type[rev]);
  };

// Вывод подсказки при наведении
  map.addEventListener("mousemove",function(e) {
     var target = getTargetElement(e.target,sel_type[rev]);
     title.style.display = "inline-block";
     title.style.left = (e.pageX + 15) + 'px';
     title.style.top = (e.pageY + 75) + 'px';
     var title_text;
     if (rev==1) { 
        title_text = region_title[target.id]  + ": " + calcRegion(target);
     } else {
        title_text = area_title[target.id]   + ": " + calcFederal(target);
     }
     title.innerHTML = title_text;
  });

  function calcRegion(target) {
     var data = region_data[target.id];
     var str;
     if (federal_data == "sum") {
        str = fric(data,1);
     } else if (federal_data == "average") {
        str = fric(data,1) + "%";
	 }
     return str;
  }
  
// Расчет показателя для федерального округа
  function calcFederal(target) {
     var regs = target.getElementsByClassName("region");
	 var data = 0;
     var str;
     for (var i = 0; i < regs.length; i++) {
	     var id = regs[i].id;
         data += region_data[id];
     }
     if (federal_data == "sum") {
        str = fric(data,1);
     } else if (federal_data == "average") {
        str = fric(data,regs.length) + "%";
	 }
     return str;
  }

// Функция округления до 2 значащих цифр
  function fric(num,count) {
     var res = (num > 10 * count)?   Math.round(num/count):
               (num > count)?  Math.round(num * 10/count) / 10:
               Math.round(num * 100/count) / 100;
     return res;
  }


// Восстановление стиля
  map.addEventListener("mouseout",function(e) {
     var target = getTargetElement(e.target,sel_type[rev]);
     title.style.display = "none";
  });


  function getTargetElement(elem,class_name) {
      var cl = elem.getAttribute("class");
      if (cl && (cl == class_name)) {
         return elem;
      } 
      if (elem.parentNode) {
         return getTargetElement(elem.parentNode,class_name);
      }
  }

};
