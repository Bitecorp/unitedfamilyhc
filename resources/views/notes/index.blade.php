@extends('layouts.default')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
@endpush

@push('css')

    
@endpush

@section('content')
        @include('flash::message')
        <!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
                    <h4 class="panel-title">
                        Notes
                    </h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        @if(Auth::user()->role_id == 1)
                            <a href="{{ route('notesSubServices.create') }}" class="btn btn-xs btn-icon btn-circle btn-primary" class="pull-right"><i class="fa fa-plus"></i></a>
                        @endif
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
                    <div class="col-xs-12 ">
                        <table id="tableNotes" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>
                                    <th width="1%"></th>
                                    <th class="text-nowrap">Worker</th>
                                    <th class="text-nowrap">Service</th>
                                    <th class="text-nowrap">Sub Service</th>
                                    <th class="text-nowrap">Patiente</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notes as $key => $note)
                                    <tr>
                                        <td width="1%" class="f-s-600 text-inverse">{{ $key + 1 }}</td>
                                        <td>{{ $note['worker_id']['fullName'] }}</td>
                                        <td>{{ $note['service_id']['nameService'] }}</td>
                                        <td>{{ $note['sub_service_id']['nameSubService'] }}</td>
                                        <td>{{ $note['patiente_id']['fullName'] }}</td>
                                        <td>

                                        @if ($note['status'] == 2)
                                            @if (($note['firma'] != '' && $note['firma'] != null) && ($note['note'] == '' || $note['note'] == null))
                                                Pending Notes
                                            @elseif (($note['firma'] == '' || $note['firma'] == null) && ($note['note'] != '' || $note['note'] != null))
                                                Pending Signature
                                            @elseif (($note['firma'] == '' || $note['firma'] == null) && ($note['note'] == '' || $note['note'] == null))
                                                Pending Notes and Signature
                                            @endif
                                        @elseif ($note['status'] == 3)
                                            Full Service
                                        @endif
                                            
                                        
                                        </td>
                                        <td class="with-btn" nowrap>
                                            <div>
                                                {!! Form::open(['route' => ['notesSubServices.destroy', $note['id']], 'method' => 'delete']) !!}
                                                    <a href="{{ route('notesSubServices.show', [ $note['id'] ]) }}" class='btn btn-sm btn-primary' ><i class="fa fa-eye"></i> Show </a>
                                                    @if ($note['status'] == 2 || Auth::user()->role_id == 1)
                                                        <a href="{{ route('notesSubServices.edit', [ $note['id'] ]) }}" class='btn btn-sm btn-warning'><i class="fa fa-edit"></i> Edit </a>
                                                    @endif
                                                    @if(Auth::user()->role_id == 1)
                                                        {!! Form::button('<a><i class="fa fa-trash"></i> Delete </a>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('The record pertaining to this note will also be deleted, are you sure?')"]) !!}
                                                    @endif
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
				</div>
				<!-- end panel-body -->
			</div>

            @foreach($notes as $key => $note)
                <div class="modal fade" id="exampleModal_{{ $key  }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel_{{ $key  }}">Signature</h5>
                            <button id="btn-clear-signature-x" type="button" class="close" data-dismiss="modal_{{ $key  }}" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" >
                            
                            <canvas id="signature"></canvas>

                        </div>
                        <div id="signature-left-buttons-holder" class="modal-footer">
                            <button id="btn-clear-signature" type="button" class="btn btn-secondary" data-dismiss="modal_{{ $key  }}">Close</button>
                            <button id="btn-save-signature" type="button" class="btn btn-primary">Save</button>
                        </div>
                        </div>
                    </div>
                </div>
            @endforeach
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#tableNotes').DataTable( {
                retrieve: true,
                paging: true,
                searching: true,
                responsive: true,
                autoFill: true,
            });
        });
    </script>

    <script>

        'use strict';

        let prps = {
            signaturePad: null
        };

        function Signature() {

            prps.signaturePad = this.signaturePad(document.getElementById('signature'));

            this.onClickOnClearBtn();
            this.onClickOnSaveSignature();
            this.onResizeCanvas();

        }

        Signature.prototype.onResizeCanvas = function () {
            let canvas = document.getElementById('signature'),
                resizeCanvas = () => {
                    canvas.width = window.innerWidth;
                    canvas.height = window.innerHeight;
                };
            window.addEventListener('resize', resizeCanvas, false);
            resizeCanvas();
        };

        Signature.prototype.onClickOnClearBtn = function() {
            document.getElementById('btn-clear-signature').addEventListener('click', () => prps.signaturePad.clear());
            document.getElementById('btn-clear-signature-x').addEventListener('click', () => prps.signaturePad.clear());
        };

        Signature.prototype.onClickOnSaveSignature = function() {
            document.getElementById('btn-save-signature').addEventListener('click', () => {

                if (prps.signaturePad.isEmpty() === true) {
                    alert('Please, sign before saving!');
                    return false;
                }

                let svg = prps.signaturePad.svg();
                console.log(svg);
                prps.signaturePad.clear();
                alert('SVG logged to console');

            });
        };

        Signature.prototype.signaturePad = function(_canvas, _opts) {

            let _this = SignaturePad;

            function Point(x, y, time) {
                this.x = x;
                this.y = y;
                this.time = time || new Date().getTime();
            }

            Point.prototype.velocityFrom = function(start) {
                return this.time !== start.time ? this.distanceTo(start) / (this.time - start.time) : 1;
            };

            Point.prototype.distanceTo = function(start) {
                return Math.sqrt(Math.pow(this.x - start.x, 2) + Math.pow(this.y - start.y, 2));
            };

            function Bezier(startPoint, control1, control2, endPoint) {
                this.startPoint = startPoint;
                this.control1 = control1;
                this.control2 = control2;
                this.endPoint = endPoint;
            }

            Bezier.prototype.length = function() {
                let steps = 10,
                    length = 0,
                    px = void 0,
                    py = void 0;
                for (let i = 0; i <= steps; i += 1) {
                    let t = i / steps,
                        cx = Bezier.prototype._point(t, this.startPoint.x, this.control1.x, this.control2.x, this.endPoint.x),
                        cy = Bezier.prototype._point(t, this.startPoint.y, this.control1.y, this.control2.y, this.endPoint.y);
                    if (i > 0) {
                        let xdiff = cx - px,
                            ydiff = cy - py;
                        length += Math.sqrt(xdiff * xdiff + ydiff * ydiff);
                    }
                    px = cx;
                    py = cy;
                }
                return length;
            };

            Bezier.prototype._point = function(t, start, c1, c2, end) {
                return start * (1.0 - t) * (1.0 - t) * (1.0 - t) + 3.0 * c1 * (1.0 - t) * (1.0 - t) * t + 3.0 * c2 * (1.0 - t) * t * t + end * t * t * t;
            };

            function throttle(func, wait, options) {
                let context, args, result,
                    timeout = null,
                    previous = 0;
                if (!options) options = {};
                let later = function later() {
                    previous = options.leading === false ? 0 : Date.now();
                    timeout = null;
                    result = func.apply(context, args);
                    if (!timeout)
                        context = args = null;
                };
                return function () {
                    let now = Date.now();
                    if (!previous && options.leading === false)
                        previous = now;
                    let remaining = wait - (now - previous);
                    context = this;
                    args = arguments;
                    if (remaining <= 0 || remaining > wait) {
                        if (timeout) {
                            clearTimeout(timeout);
                            timeout = null;
                        }
                        previous = now;
                        result = func.apply(context, args);
                        if (!timeout)
                            context = args = null;
                    } else if (!timeout && options.trailing !== false)
                        timeout = setTimeout(later, remaining);
                    return result;
                };
            }

            function SignaturePad(canvas, options) {
                let opts = options || {};
                _this.velocityFilterWeight = opts.velocityFilterWeight || 0.7;
                _this.minWidth = opts.minWidth || 0.5;
                _this.maxWidth = opts.maxWidth || 2.5;
                _this.throttle = 'throttle' in opts ? opts.throttle : 16;
                if (_this.throttle)
                    _this._strokeMoveUpdate = throttle(SignaturePad.prototype._strokeUpdate, _this.throttle);
                else
                    _this._strokeMoveUpdate = SignaturePad.prototype._strokeUpdate;
                _this.dotSize = opts.dotSize || function () { return (_this.minWidth + _this.maxWidth) / 2; };
                _this.penColor = opts.penColor || 'black';
                _this.backgroundColor = opts.backgroundColor || 'rgba(0,0,0,0)';
                _this.onBegin = opts.onBegin;
                _this.onEnd = opts.onEnd;
                _this._canvas = canvas;
                _this._ctx = canvas.getContext('2d');
                _this.prototype.clear();
                _this._handleMouseDown = function (event) {
                    if (event.which === 1) {
                        _this._mouseButtonDown = true;
                        _this.prototype._strokeBegin(event);
                    }
                };
                _this._handleMouseMove = function (event) {
                    if (_this._mouseButtonDown)
                        _this._strokeMoveUpdate(event);
                };
                _this._handleMouseUp = function (event) {
                    if (event.which === 1 && _this._mouseButtonDown) {
                        _this._mouseButtonDown = false;
                        _this.prototype._strokeEnd(event);
                    }
                };
                _this._handleTouchStart = function (event) {
                    if (event.targetTouches.length === 1) {
                        let touch = event.changedTouches[0];
                        _this.prototype._strokeBegin(touch);
                    }
                };
                _this._handleTouchMove = function (event) {
                    event.preventDefault();
                    let touch = event.targetTouches[0];
                    _this._strokeMoveUpdate(touch);
                };

                _this._handleTouchEnd = function (event) {
                    let wasCanvasTouched = event.target === _this._canvas;
                    if (wasCanvasTouched) {
                        event.preventDefault();
                        _this.prototype._strokeEnd(event);
                    }
                };
                _this.prototype.on();
            }

            SignaturePad.prototype.clear = function() {
                let ctx = _this._ctx,
                    canvas = _this._canvas;
                ctx.fillStyle = _this.backgroundColor;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                _this._data = [];
                _this.prototype._reset();
                _this._isEmpty = true;
            };

            SignaturePad.prototype.fromDataURL = function(dataUrl) {
                let options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
                    image = new Image(),
                    ratio = options.ratio || window.devicePixelRatio || 1,
                    width = options.width || _this._canvas.width / ratio,
                    height = options.height || _this._canvas.height / ratio;
                _this.prototype._reset();
                image.src = dataUrl;
                image.onload = () => {
                    _this._ctx.drawImage(image, 0, 0, width, height);
                };
                _this._isEmpty = false;
            };

            SignaturePad.prototype.toDataURL = function(type) {
                let _canvas;
                switch (type) {
                    case 'image/svg+xml':
                        return _this.prototype._toSVG(true);
                    default:
                        for (let _len = arguments.length, options = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++)
                            options[_key - 1] = arguments[_key];
                        return (_canvas = _this._canvas).toDataURL.apply(_canvas, [type].concat(options));
                }
            };

            SignaturePad.prototype.svg = function() {
                return _this.prototype._toSVG();
            };

            SignaturePad.prototype.on = function() {
                _this.prototype._handleMouseEvents();
                _this.prototype._handleTouchEvents();
            };

            SignaturePad.prototype.off = function() {
                _this._canvas.removeEventListener('mousedown', _this._handleMouseDown);
                _this._canvas.removeEventListener('mousemove', _this._handleMouseMove);
                document.removeEventListener('mouseup', _this._handleMouseUp);
                _this._canvas.removeEventListener('touchstart', _this._handleTouchStart);
                _this._canvas.removeEventListener('touchmove', _this._handleTouchMove);
                _this._canvas.removeEventListener('touchend', _this._handleTouchEnd);
            };

            SignaturePad.prototype.isEmpty = function() {
                return _this._isEmpty;
            };

            SignaturePad.prototype._strokeBegin = function(event) {
                _this._data.push([]);
                _this.prototype._reset();
                _this.prototype._strokeUpdate(event);
                if (typeof _this.onBegin === 'function')
                    _this.onBegin(event);
            };

            SignaturePad.prototype._strokeUpdate = function(event) {
                let x = event.clientX,
                    y = event.clientY,
                    point = _this.prototype._createPoint(x, y),
                    _addPoint = _this.prototype._addPoint(point),
                    curve = _addPoint.curve,
                    widths = _addPoint.widths;
                if (curve && widths)
                    _this.prototype._drawCurve(curve, widths.start, widths.end);
                _this._data[_this._data.length - 1].push({
                    x: point.x,
                    y: point.y,
                    time: point.time,
                    color: _this.penColor
                });
            };

            SignaturePad.prototype._strokeEnd = function(event) {
                let canDrawCurve = _this.points.length > 2;
                let point = _this.points[0];
                if (!canDrawCurve && point)
                    _this.prototype._drawDot(point);
                if (typeof _this.onEnd === 'function')
                    _this.onEnd(event);
            };

            SignaturePad.prototype._handleMouseEvents = function() {
                _this._mouseButtonDown = false;
                _this._canvas.addEventListener('mousedown', _this._handleMouseDown);
                _this._canvas.addEventListener('mousemove', _this._handleMouseMove);
                document.addEventListener('mouseup', _this._handleMouseUp);
            };

            SignaturePad.prototype._handleTouchEvents = function() {
                _this._canvas.style.msTouchAction = 'none';
                _this._canvas.style.touchAction = 'none';
                _this._canvas.addEventListener('touchstart', _this._handleTouchStart);
                _this._canvas.addEventListener('touchmove', _this._handleTouchMove);
                _this._canvas.addEventListener('touchend', _this._handleTouchEnd);
            };

            SignaturePad.prototype._reset = function() {
                _this.points = [];
                _this._lastVelocity = 0;
                _this._lastWidth = (_this.minWidth + _this.maxWidth) / 2;
                _this._ctx.fillStyle = _this.penColor;
            };

            SignaturePad.prototype._createPoint = function(x, y, time) {
                let rect = _this._canvas.getBoundingClientRect();
                return new Point(x - rect.left, y - rect.top, time || new Date().getTime());
            };

            SignaturePad.prototype._addPoint = function(point) {
                let points = _this.points,
                    tmp = void 0;
                points.push(point);
                if (points.length > 2) {
                    if (points.length === 3)
                        points.unshift(points[0]);
                    tmp = _this.prototype._calculateCurveControlPoints(points[0], points[1], points[2]);
                    let c2 = tmp.c2;
                    tmp = _this.prototype._calculateCurveControlPoints(points[1], points[2], points[3]);
                    let c3 = tmp.c1,
                        curve = new Bezier(points[1], c2, c3, points[2]),
                        widths = _this.prototype._calculateCurveWidths(curve);
                    points.shift();
                    return { curve: curve, widths: widths };
                }
                return {};
            };

            SignaturePad.prototype._calculateCurveControlPoints = function(s1, s2, s3) {
                let dx1 = s1.x - s2.x,
                    dy1 = s1.y - s2.y,
                    dx2 = s2.x - s3.x,
                    dy2 = s2.y - s3.y,
                    m1 = { x: (s1.x + s2.x) / 2.0, y: (s1.y + s2.y) / 2.0 },
                    m2 = { x: (s2.x + s3.x) / 2.0, y: (s2.y + s3.y) / 2.0 },
                    l1 = Math.sqrt(dx1 * dx1 + dy1 * dy1),
                    l2 = Math.sqrt(dx2 * dx2 + dy2 * dy2),
                    dxm = m1.x - m2.x,
                    dym = m1.y - m2.y,
                    k = l2 / (l1 + l2),
                    cm = { x: m2.x + dxm * k, y: m2.y + dym * k },
                    tx = s2.x - cm.x,
                    ty = s2.y - cm.y;
                return {
                    c1: new Point(m1.x + tx, m1.y + ty),
                    c2: new Point(m2.x + tx, m2.y + ty)
                };
            };

            SignaturePad.prototype._calculateCurveWidths = function(curve) {
                let startPoint = curve.startPoint,
                    endPoint = curve.endPoint,
                    widths = { start: null, end: null },
                    velocity = _this.velocityFilterWeight * endPoint.velocityFrom(startPoint) + (1 - _this.velocityFilterWeight) * _this._lastVelocity,
                    newWidth = _this.prototype._strokeWidth(velocity);
                widths.start = _this._lastWidth;
                widths.end = newWidth;
                _this._lastVelocity = velocity;
                _this._lastWidth = newWidth;
                return widths;
            };

            SignaturePad.prototype._strokeWidth = function(velocity) {
                return Math.max(_this.maxWidth / (velocity + 1), _this.minWidth);
            };

            SignaturePad.prototype._drawPoint = function(x, y, size) {
                let ctx = _this._ctx;
                ctx.moveTo(x, y);
                ctx.arc(x, y, size, 0, 2 * Math.PI, false);
                _this._isEmpty = false;
            };

            SignaturePad.prototype._drawCurve = function(curve, startWidth, endWidth) {
                let ctx = _this._ctx;
                let widthDelta = endWidth - startWidth;
                let drawSteps = Math.floor(curve.length());
                ctx.beginPath();
                for (let i = 0; i < drawSteps; i += 1) {
                    let t = i / drawSteps,
                        tt = t * t,
                        ttt = tt * t,
                        u = 1 - t,
                        uu = u * u,
                        uuu = uu * u,
                        x = uuu * curve.startPoint.x;
                    x += 3 * uu * t * curve.control1.x;
                    x += 3 * u * tt * curve.control2.x;
                    x += ttt * curve.endPoint.x;
                    let y = uuu * curve.startPoint.y;
                    y += 3 * uu * t * curve.control1.y;
                    y += 3 * u * tt * curve.control2.y;
                    y += ttt * curve.endPoint.y;
                    let width = startWidth + ttt * widthDelta;
                    _this.prototype._drawPoint(x, y, width);
                }
                ctx.closePath();
                ctx.fill();
            };

            SignaturePad.prototype._drawDot = function(point) {
                let ctx = _this._ctx,
                    width = typeof _this.dotSize === 'function' ? _this.dotSize() : _this.dotSize;
                ctx.beginPath();
                _this.prototype._drawPoint(point.x, point.y, width);
                ctx.closePath();
                ctx.fill();
            };

            SignaturePad.prototype._fromData = function(pointGroups, drawCurve, drawDot) {
                for (let i = 0; i < pointGroups.length; i += 1) {
                    let group = pointGroups[i];
                    if (group.length > 1) {
                        for (let j = 0; j < group.length; j += 1) {
                            let rawPoint = group[j],
                                point = new Point(rawPoint.x, rawPoint.y, rawPoint.time),
                                color = rawPoint.color;
                            if (j === 0) {
                                _this.prototype._reset();
                                _this.prototype._addPoint(point);
                            } else if (j !== group.length - 1) {
                                let _addPoint2 = _this.prototype._addPoint(point),
                                    curve = _addPoint2.curve,
                                    widths = _addPoint2.widths;
                                if (curve && widths)
                                    drawCurve(curve, widths, color);
                            }
                        }
                    } else {
                        _this.prototype._reset();
                        let _rawPoint = group[0];
                        drawDot(_rawPoint);
                    }
                }
            };

            SignaturePad.prototype._toSVG = function(returnBase64) {
                let pointGroups = _this._data,
                    canvas = _this._canvas,
                    ratio = Math.max(window.devicePixelRatio || 1, 1),
                    minX = 0,
                    minY = 0,
                    maxX = canvas.width / ratio,
                    maxY = canvas.height / ratio,
                    svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.setAttributeNS(null, 'width', canvas.width);
                svg.setAttributeNS(null, 'height', canvas.height);
                _this.prototype._fromData(pointGroups, function (curve, widths, color) {
                    let path = document.createElement('path');
                    if (!isNaN(curve.control1.x) && !isNaN(curve.control1.y) && !isNaN(curve.control2.x) && !isNaN(curve.control2.y)) {
                        let attr = 'M ' + curve.startPoint.x.toFixed(3) + ',' + curve.startPoint.y.toFixed(3) + ' ' + ('C ' + curve.control1.x.toFixed(3) + ',' + curve.control1.y.toFixed(3) + ' ') + (curve.control2.x.toFixed(3) + ',' + curve.control2.y.toFixed(3) + ' ') + (curve.endPoint.x.toFixed(3) + ',' + curve.endPoint.y.toFixed(3));
                        path.setAttribute('d', attr);
                        path.setAttribute('stroke-width', (widths.end * 2.25).toFixed(3));
                        path.setAttribute('stroke', color);
                        path.setAttribute('fill', 'none');
                        path.setAttribute('stroke-linecap', 'round');
                        svg.appendChild(path);
                    }
                }, function (rawPoint) {
                    let circle = document.createElement('circle'),
                        dotSize = typeof _this.dotSize === 'function' ? _this.dotSize() : _this.dotSize;
                    circle.setAttribute('r', dotSize);
                    circle.setAttribute('cx', rawPoint.x);
                    circle.setAttribute('cy', rawPoint.y);
                    circle.setAttribute('fill', rawPoint.color);
                    svg.appendChild(circle);
                });
                let prefix = 'data:image/svg+xml;base64,',
                    header = '<svg' + ' xmlns="http://www.w3.org/2000/svg"' + ' xmlns:xlink="http://www.w3.org/1999/xlink"' + (' viewBox="' + minX + ' ' + minY + ' ' + maxX + ' ' + maxY + '"') + (' width="' + maxX + '"') + (' height="' + maxY + '"') + '>',
                    body = svg.innerHTML;
                if (body === undefined) {
                    let dummy = document.createElement('dummy'),
                        nodes = svg.childNodes;
                    dummy.innerHTML = '';
                    for (let i = 0; i < nodes.length; i += 1)
                        dummy.appendChild(nodes[i].cloneNode(true));
                    body = dummy.innerHTML;
                }
                let footer = '</svg>',
                    data = header + body + footer;
                return (typeof returnBase64 === 'undefined' || returnBase64 === false) ? data : prefix + btoa(data);
            };

            SignaturePad.prototype.fromData = function(pointGroups) {
                _this.prototype.clear();
                _this.prototype._fromData(pointGroups, function (curve, widths) {
                    return _this.prototype._drawCurve(curve, widths.start, widths.end);
                }, function (rawPoint) {
                    return _this.prototype._drawDot(rawPoint);
                });
            };

            SignaturePad.prototype.toData = function() {
                return _this._data;
            };

            return new SignaturePad(_canvas, _opts);

        };

        let signature = new Signature();

        /* Boilerplate code */
        document.getElementById('show-signature-pad').addEventListener('click', () => {

            let handler = () => {
                window.removeEventListener('popstate', handler);
                prps.signaturePad.clear();
                document.getElementById('signature-holder').classList.add('hide');
            };

            history.pushState(null, 'SignaturePad', '#');
            window.addEventListener('popstate', handler);
            document.getElementById('signature-holder').classList.remove('hide');

        });

    </script>

	<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-select/js/dataTables.select.min.js"></script>
	<script src="/assets/plugins/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
	<script src="/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
	<script src="/assets/plugins/jszip/dist/jszip.min.js"></script>
	<script src="/assets/js/demo/table-manage-combine.demo.js"></script>
@endpush

