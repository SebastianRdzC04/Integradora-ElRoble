// Grafico 1
let myChart = echarts.init(document.getElementById('grafico2'));
const option = {
  tooltip: {
    trigger: 'item'
  },
  legend: {
    top: '5%',
    left: 'center'
  },
  series: [
    {
      name: 'Rentas',
      type: 'pie',
      radius: ['40%', '70%'],
      avoidLabelOverlap: true,
      itemStyle: {
        borderRadius: 10,
        borderColor: '#fff',
        borderWidth: 2
      },
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: true,
          fontSize: 30,
          fontWeight: 'bold'
        }
      },
      labelLine: {
        show: false
      },
      data: datos
    }
  ]
};
myChart.setOption(option);
// Grafico 2
let myChart2 = echarts.init(document.getElementById('grafico3'));
var option2;
option2 = {
  tooltip: {
    trigger: 'item'
  },
  xAxis: {
    type: 'category',
    data: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
  },
  yAxis: {
    type: 'value'
  },
  series: datos2
};
myChart2.setOption(option2);
// Grafico 3
let myChart3 = echarts.init(document.getElementById('grafico1'));
const option3 = {
  tooltip: {
    trigger: 'item'
  },
  legend: {
    top: '5%',
    left: 'center'
  },
  xAxis: {
    type: 'category',
    data: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
  },
  yAxis: {
    type: 'value'
  },
  series: [
    {
      type: 'bar',
      data: datos3
    },
    {
      type: 'line',
      data: datos3
    }
  ]
}
myChart3.setOption(option3);
// hacer que cuando cambie el select con id year se envie el formulario y se ejecute la funcion que puse en el onsubmit en el formulario
// cuando cambie el select con id year se envie el formulario 
$('#year').change(function () {
  $('#profitsYear').submit();
});


const updateGraph3Form = (form) => {
  event.preventDefault();
  $.get($(form).attr('action'), $(form).serialize(), function (response) {
    option3.series[0].data = response;
    option3.series[1].data = response;

    myChart3.setOption(option3);
  });

}