<?php
/**
 * File: statistics.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/8/13 22:00
 * Description:
 */
$this->cs->registerScript('echarts', "
function getSaleStockOption(data){
    return  {
        tooltip : {
            trigger: 'item',
        },
        legend: {
            orient : 'vertical',
            x : 'left',
            data:['已使用','未使用']
        },
        series: [
            {
                center: ['50%','50%'],
                radius: [0, '70%'],
                selectedMode: 'single',
                type: 'pie',
                data: data
            },
        ]
    };
}
function getDailyTrafficOption(data){
    var option = {
        tooltip : {
            trigger: 'item'
        },
        legend: {
            data: data.emailList,
            x : 'right',
            y : 'top',
            itemWidth:10,
            itemHeight:14,
            orient : 'vertical',
        },
        toolbox: {
            show : false,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : data.dayList
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLabel : {
                    formatter: '{value} MB'
                }
            }
        ],
        series: []
    };

    for(var email in data.seriesMap){
        var dataList = data.seriesMap[email];
        option.series.push({
            name: email,
            type: 'line',
            data: dataList,
//            markPoint : {
//                data : [
//                    {type : 'max', name: '最大值'},
//                    {type : 'min', name: '最小值'}
//                ]
//            },
//            markLine : {
//                data : [
//                    {type : 'average', name: '平均值'}
//                ]
//            }
        });
    }
    return option;
}
function getTraffic(charts){
    charts.showLoading({
        text: '正在努力的读取数据中...',
    });
    $.get('/admin/wakfu/statistics',{operationType:'traffic'},function(res){
        if(res.status == 200){
            var option = getSaleStockOption(res.data);
            charts.clear()
            charts.setOption(option);
        }
        charts.hideLoading();
    });
}
function getDailyTraffic(charts){
    charts.showLoading({
        text: '正在努力的读取数据中...',
    });
    $.get('/admin/wakfu/statistics',{operationType:'dailyTraffic'},function(res){
        if(res.status == 200){
            var option = getDailyTrafficOption(res.data);
            charts.clear()
            charts.setOption(option);
        }
        charts.hideLoading();
    });
}
var traffic = echarts.init(document.getElementById('traffic'));
getTraffic(traffic);
var dailyTraffic = echarts.init(document.getElementById('dailyTraffic'));
getDailyTraffic(dailyTraffic);
");
?>
<div class="panel panel-default">
    <div class="panel-heading">统计报表</div>
    <div class="panel-body">
        <div class="col-md-12">
            <div id="traffic" style="width:800px; height:400px; margin: 0 auto;"></div>
        </div>
    </div>
    <div class="panel-heading">流量日报</div>
    <div class="panel-body">
        <div class="col-md-12">
            <div id="dailyTraffic" style="width:800px; height:400px; margin: 0 auto;"></div>
        </div>
    </div>
</div>
