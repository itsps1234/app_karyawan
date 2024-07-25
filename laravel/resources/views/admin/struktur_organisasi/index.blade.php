@extends('admin.layouts.dashboard')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
<link href="https://cdn.syncfusion.com/ej2/material.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/4.0.1/css/jquery.orgchart.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/4.0.1/css/jquery.orgchart.min.css"> -->
<style type="text/css">
    .my-swal {
        z-index: X;
    }
</style>
@endsection
@section('isi')
@include('sweetalert::alert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-4">
        <!-- Transactions -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">STRUKTUR ORGANISASI</h5>
                        <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-0" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link waves-effect waves-light @if($holding=='sp') active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                                    <i class="tf-icons mdi mdi-family-tree me-1"></i> SP
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link waves-effect waves-light @if($holding=='sps') active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false" tabindex="-1">
                                    <i class="tf-icons mdi mdi-family-tree me-1"></i> SPS
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link waves-effect waves-light @if($holding=='sip') active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false" tabindex="-1">
                                    <i class="tf-icons mdi mdi-family-tree me-1"></i> SIP
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade @if($holding=='sp') active show @endif" id="navs-pills-top-home" role="tabpanel">

                        <div class="card-body">

                            <div id="chartDiv1" class="chartDiv" style="max-width: 100%;  height: 800px"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade @if($holding=='sps') active show @endif" id="navs-pills-top-profile" role="tabpanel">

                        <div class="card-body">

                            <div id="chartDiv2" class="chartDiv2" style="max-width: 100%; height: 800px"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade @if($holding=='sip') active show @endif" id="navs-pills-top-messages" role="tabpanel">

                        <div class="card-body">

                            <div id="chartDiv3" class="chartDiv3" style="max-width: 100%; height: 800px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Transactions -->
    <!--/ Data Tables -->
</div>
</div>
@endsection
@section('js')
<script src="https://cdn.syncfusion.com/ej2/dist/ej2.min.js" type="text/javascript"></script>
<script src="https://code.jscharting.com/latest/jscharting.js"></script>
<script type="text/javascript" src="https://code.jscharting.com/latest/modules/types.js"></script>
<!-- <script type="text/javascript" src="https://code.jscharting.com/latest/modules/toolbar.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    var selectedPoint;
    var highlightColor = '#5C6BC0',
        mutedHighlightColor = '#9FA8DA',
        mutedFill = '#f3f4fa',
        selectedFill = '#E8EAF6',
        normalFill = 'white';

    var points = <?php echo json_encode($user) ?>;

    console.log(points);
    var chart = JSC.chart('chartDiv1', {
        debug: true,
        type: 'organizational',
        defaultTooltip_enabled: true,

        /* These options will apply to all annotations including point nodes. */
        defaultAnnotation: {
            padding: [5, 10],
            margin: 6
        },
        annotations: [{
            position: 'bottom',
            label_text: 'STRUKTUR ORGANISASI CV. SUMBER PANGAN'
        }],

        defaultSeries: {
            color: normalFill,
            /* Point selection is disabled because it is managed manually with point click events. */
            pointSelection: false
        },
        defaultPoint: {
            focusGlow: true,
            connectorLine: {
                color: '#e0e0e0',
                radius: [10, 3]
            },
            label: {
                text: '%photo%name<br><span style="color:#9E9E9E">%role</span>',
                style_color: 'black'
            },
            outline: {
                color: '#e0e0e0',
                width: 1
            },
            annotation: {
                syncHeight_with: 'level'
            },
            states: {
                mute: {
                    opacity: 0.8,
                    outline: {
                        color: mutedHighlightColor,
                        opacity: 0.9,
                        width: 2
                    }
                },
                select: {
                    enabled: true,
                    outline: {
                        color: highlightColor,
                        width: 2
                    },
                    color: selectedFill
                },
                hover: {
                    outline: {
                        color: mutedHighlightColor,
                        width: 2
                    },
                    color: mutedFill
                }
            },
            events: {
                click: pointClick,
                mouseOver: pointMouseOver,
                mouseOut: pointMouseOut
            }
        },
        series: [{
            points: points
        }]
    });

    /** 
     * Event Handlers 
     */

    function pointClick() {
        var point = this,
            chart = point.chart;
        resetStyles(chart);
        if (point.id === selectedPoint) {
            selectedPoint = undefined;
            return;
        }
        selectedPoint = point.id;
        styleSelectedPoint(chart);
    }

    function pointMouseOver() {
        var point = this,
            chart = point.chart;
        chart.connectors([point.id, 'up'], {
            color: mutedHighlightColor,
            width: 2
        });
        chart
            .series()
            .points([point.id, 'up'])
            .options({
                muted: true
            });
    }

    function pointMouseOut() {
        var point = this,
            chart = point.chart;
        // Reset point and line styling. 
        resetStyles(chart);
        // Style clicked points 
        styleSelectedPoint(chart);
        return false;
    }

    /** 
     * Styling helper functions 
     */

    function styleSelectedPoint(chart) {
        if (selectedPoint) {
            chart.connectors([selectedPoint, 'up'], {
                color: highlightColor,
                width: 2
            });
            chart
                .series()
                .points([selectedPoint, 'up'])
                .options({
                    selected: true,
                    muted: false
                });
        }
    }

    /** 
     * Clears connectors and point states. 
     * @param chart Chart object 
     */
    function resetStyles(chart) {
        chart.connectors();
        chart
            .series()
            .points()
            .options({
                selected: false,
                muted: false
            });
    }

    function getImgText(name) {
        return (
            '<img width=50 height=50 align=center margin_bottom=4 margin_top=4 src=' +
            name +
            '><br>'
        );
    }
</script>
<script>
    var selectedPoint;
    var highlightColor = '#5C6BC0',
        mutedHighlightColor = '#9FA8DA',
        mutedFill = '#f3f4fa',
        selectedFill = '#E8EAF6',
        normalFill = 'white';

    var points = <?php echo json_encode($user1) ?>;

    console.log(points);
    var chart1 = JSC.chart('chartDiv2', {
        debug: true,
        type: 'organizational',
        defaultTooltip_enabled: true,

        /* These options will apply to all annotations including point nodes. */
        defaultAnnotation: {
            padding: [5, 10],
            margin: 6
        },
        annotations: [{
            position: 'bottom',
            label_text: 'STRUKTUR ORGANISASI PT. SURYA PANGAN SEMESTA'
        }],

        defaultSeries: {
            color: normalFill,
            /* Point selection is disabled because it is managed manually with point click events. */
            pointSelection: false
        },
        defaultPoint: {
            focusGlow: false,
            connectorLine: {
                color: '#e0e0e0',
                radius: [10, 3]
            },
            label: {
                text: '%photo%name<br><span style="color:#9E9E9E">%role</span>',
                style_color: 'black'
            },
            outline: {
                color: '#e0e0e0',
                width: 1
            },
            annotation: {
                syncHeight_with: 'level'
            },
            states: {
                mute: {
                    opacity: 0.8,
                    outline: {
                        color: mutedHighlightColor,
                        opacity: 0.9,
                        width: 2
                    }
                },
                select: {
                    enabled: true,
                    outline: {
                        color: highlightColor,
                        width: 2
                    },
                    color: selectedFill
                },
                hover: {
                    outline: {
                        color: mutedHighlightColor,
                        width: 2
                    },
                    color: mutedFill
                }
            },
            events: {
                click: pointClick,
                mouseOver: pointMouseOver,
                mouseOut: pointMouseOut
            }
        },
        series: [{
            points: points
        }]
    });
    chart1.redraw();
    /** 
     * Event Handlers 
     */

    function pointClick() {
        var point = this,
            chart = point.chart;
        resetStyles(chart);
        if (point.id === selectedPoint) {
            selectedPoint = undefined;
            return;
        }
        selectedPoint = point.id;
        styleSelectedPoint(chart);
    }

    function pointMouseOver() {
        var point = this,
            chart = point.chart;
        chart.connectors([point.id, 'up'], {
            color: mutedHighlightColor,
            width: 2
        });
        chart
            .series()
            .points([point.id, 'up'])
            .options({
                muted: true
            });
    }

    function pointMouseOut() {
        var point = this,
            chart = point.chart;
        // Reset point and line styling. 
        resetStyles(chart);
        // Style clicked points 
        styleSelectedPoint(chart);
        return false;
    }

    /** 
     * Styling helper functions 
     */

    function styleSelectedPoint(chart) {
        if (selectedPoint) {
            chart.connectors([selectedPoint, 'up'], {
                color: highlightColor,
                width: 2
            });
            chart
                .series()
                .points([selectedPoint, 'up'])
                .options({
                    selected: true,
                    muted: false
                });
        }
    }

    /** 
     * Clears connectors and point states. 
     * @param chart Chart object 
     */
    function resetStyles(chart) {
        chart.connectors();
        chart
            .series()
            .points()
            .options({
                selected: false,
                muted: false
            });
    }

    function getImgText(name) {
        return (
            '<img width=50 height=50 align=center margin_bottom=4 margin_top=4 src=' +
            name +
            '><br>'
        );
    }
</script>
<script>
    var selectedPoint;
    var highlightColor = '#5C6BC0',
        mutedHighlightColor = '#9FA8DA',
        mutedFill = '#f3f4fa',
        selectedFill = '#E8EAF6',
        normalFill = 'white';

    var points = <?php echo json_encode($user2) ?>;

    console.log(points);
    var chart = JSC.chart('chartDiv3', {
        debug: true,
        type: 'organizational',
        defaultTooltip_enabled: true,

        /* These options will apply to all annotations including point nodes. */
        defaultAnnotation: {
            padding: [5, 10],
            margin: 6
        },
        annotations: [{
            position: 'bottom',
            label_text: 'STRUKTUR ORGANISASI CV. SURYA INTI PANGAN'
        }],

        defaultSeries: {
            color: normalFill,
            /* Point selection is disabled because it is managed manually with point click events. */
            pointSelection: false
        },
        defaultPoint: {
            focusGlow: false,
            connectorLine: {
                color: '#e0e0e0',
                radius: [10, 3]
            },
            label: {
                text: '%photo%name<br><span style="color:#9E9E9E">%role</span>',
                style_color: 'black'
            },
            outline: {
                color: '#e0e0e0',
                width: 1
            },
            annotation: {
                syncHeight_with: 'level'
            },
            states: {
                mute: {
                    opacity: 0.8,
                    outline: {
                        color: mutedHighlightColor,
                        opacity: 0.9,
                        width: 2
                    }
                },
                select: {
                    enabled: true,
                    outline: {
                        color: highlightColor,
                        width: 2
                    },
                    color: selectedFill
                },
                hover: {
                    outline: {
                        color: mutedHighlightColor,
                        width: 2
                    },
                    color: mutedFill
                }
            },
            events: {
                click: pointClick,
                mouseOver: pointMouseOver,
                mouseOut: pointMouseOut
            }
        },
        series: [{
            points: points
        }]
    });

    /** 
     * Event Handlers 
     */

    function pointClick() {
        var point = this,
            chart = point.chart;
        resetStyles(chart);
        if (point.id === selectedPoint) {
            selectedPoint = undefined;
            return;
        }
        selectedPoint = point.id;
        styleSelectedPoint(chart);
    }

    function pointMouseOver() {
        var point = this,
            chart = point.chart;
        chart.connectors([point.id, 'up'], {
            color: mutedHighlightColor,
            width: 2
        });
        chart
            .series()
            .points([point.id, 'up'])
            .options({
                muted: true
            });
    }

    function pointMouseOut() {
        var point = this,
            chart = point.chart;
        // Reset point and line styling. 
        resetStyles(chart);
        // Style clicked points 
        styleSelectedPoint(chart);
        return false;
    }

    /** 
     * Styling helper functions 
     */

    function styleSelectedPoint(chart) {
        if (selectedPoint) {
            chart.connectors([selectedPoint, 'up'], {
                color: highlightColor,
                width: 2
            });
            chart
                .series()
                .points([selectedPoint, 'up'])
                .options({
                    selected: true,
                    muted: false
                });
        }
    }

    /** 
     * Clears connectors and point states. 
     * @param chart Chart object 
     */
    function resetStyles(chart) {
        chart.connectors();
        chart
            .series()
            .points()
            .options({
                selected: false,
                muted: false
            });
    }

    function getImgText(name) {
        return (
            '<img width=50 height=50 align=center margin_bottom=4 margin_top=4 src=' +
            name +
            '><br>'
        );
    }
</script>


<!-- highchart -->
<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/sankey.js"></script>
<script src="https://code.highcharts.com/modules/organization.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.chart('tree', {
        chart: {
            height: 600,
            inverted: true
        },

        title: {
            text: 'Highcharts Org Chart'
        },

        accessibility: {
            point: {
                descriptionFormat: '{add index 1}. {toNode.name}' +
                    '{#if (ne toNode.name toNode.id)}, {toNode.id}{/if}, ' +
                    'reports to {fromNode.id}'
            }
        },

        series: [{
            type: 'organization',
            name: 'Highsoft',
            keys: ['from', 'to'],
            data: <?php echo json_encode($user) ?>,
            levels: [{
                level: 0,
                color: 'silver',
                dataLabels: {
                    color: 'black'
                },
                height: 25
            }, {
                level: 1,
                color: 'silver',
                dataLabels: {
                    color: 'black'
                },
                height: 25
            }, {
                level: 2,
                color: '#980104'
            }, {
                level: 4,
                color: '#359154'
            }],
            nodes: <?php echo json_encode($user_node) ?>,
            colorByPoint: false,
            color: '#007ad0',
            dataLabels: {
                color: 'white'
            },
            borderColor: 'white',
            nodeWidth: 'auto'
        }],
        tooltip: {
            outside: true
        },
        exporting: {
            allowHTML: true,
            sourceWidth: 800,
            sourceHeight: 600
        }

    });
</script> -->
@endsection