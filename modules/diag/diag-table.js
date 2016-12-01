function load_data() {
// Инициализация
   var table = document.getElementById("diag");
   var count_row = Object.keys(data_content).length;
   var tr = new Array(count_row);
   var data_sum = [];
   var max = 0;
   for (var key in data_content) {
       data_sum[key] = 0;
       for (var j=0; j < data_content[key].length; j++) {
           data_sum[key] += data_content[key][j];
       }
       if (max < data_sum[key]) max = data_sum[key];
   }
   
   var keys = Object.keys(data_sum);
   var vals = Array();
   var i = 0;
   for (var key in data_sum) {
       vals[i++] = data_sum[key];
   }
// Вывод заголовков  
  var head = document.getElementById("header");
  head.innerHTML = header;
  document.title = header;

// Сортировка данных
   if (data_sort) {
      for (var i=0; i < count_row-1; i++) {
          for (var j=i+1; j < count_row; j++) {
              if (vals[i] < vals[j]) {
                 var temp = vals[i];
                 vals[i] = vals[j];
                 vals[j] = temp;
                 temp = keys[i];
                 keys[i] = keys[j];
                 keys[j] = temp;
              }     
          }
      }
   }
   
// Вывод таблицы
   for (var i=0; i < count_row; i++) {
       tr[i] = document.createElement("tr");
       var str = "<td>" + getUGSN(keys[i]) + "</td>";
       str += "<td>" + data_title[keys[i]] + "</td>";
       str += "<td><div class='group' id='" + keys[i] + "'>";
       for (var j=0; j < data_content[keys[i]].length; j++) {
           str += createDiag(keys[i],j);
       }
       str += "</div><div class='dat'>" + data_sum[keys[i]] + "</div>";
       str += "</td>";
       tr[i].innerHTML = str;
       table.appendChild(tr[i]);
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

   
// Формирование графика
   function createDiag(key,j) {
      var width = Math.round(data_content[key][j] * width_max / max);
      var str = '<div class="pict" style="width: ' + width + 'px; background: ' + data_colors[j] + '">';
      str += '<div class="title">' + data_titles[j] + ' ' + data_content[key][j] + '</div></div>';
      return str;
   }

// Формирование кода УГСН
   function getUGSN(key) {
      return key.substring(1) + ".00.00";
   }
   
// Вывод подсказки при наведении
   table.addEventListener("mousemove",function(e) {
     var targets = e.target.getElementsByClassName("title");
     targets[0].style.left = (e.pageX + 15) + 'px';
     targets[0].style.top = (e.pageY + 15) + 'px';
  });
}