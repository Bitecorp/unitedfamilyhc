<div class="row">
    <div class="col">
        <div class="form-group" hidden>
            {!! Form::label('previa_url', 'previa_url:') !!}
            <input type="text" id='previa_url' name="previa_url" class="form-control" readonly value="{{ isset($prevUrl) && !empty($prevUrl) ? $prevUrl : URL::previous() }}" >
        </div>
    </div>

    <div class="col">
        <div class="form-group" hidden>
            {!! Form::label('register_attentions_id', 'register_attentions_id:') !!}
            <input type="text" name="register_attentions_id" class="form-control" readonly value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['register_attentions_id'] : ''}}" >
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group" hidden>
            {!! Form::label('worker_id', 'worker_id:') !!}
            <input type="text" name="worker_id" class="form-control" readonly value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['worker_id']['id'] : ''}}" >
        </div>
    </div>

    <div class="col">
        <div class="form-group" hidden>
            {!! Form::label('patiente_id', 'patiente_id:') !!}
            <input type="text" name="patiente_id" class="form-control" readonly value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['patiente_id']['id'] : ''}}" >
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group" hidden>
            {!! Form::label('service_id', 'service_id:') !!}
            <input type="text" name="service_id" class="form-control" readonly value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['service_id']['id'] : ''}}" >
        </div>
    </div>

    <div class="col">
        <div class="form-group" hidden>
            {!! Form::label('sub_service_id', 'sub_service_id:') !!}
            <input type="text" name="sub_service_id" class="form-control" readonly value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['sub_service_id']['id'] : ''}}" >
        </div>
    </div>
</div>

@if(strpos(Request::url(),'/edit') && Auth::user()->role_id == 1)

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Data Sub Service
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {!! Form::label('start', 'Start Date/Hora:') !!}
                            <input class="form-control" type="datetime-local" id="start" name="start" value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['register_attentions']->start : '' }}" {{ strpos(Request::url(), "create") || strpos(Request::url(), "edit") ? 'required' : '' }}>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group" >
                            {!! Form::label('lat_start', 'Latitud Start:') !!}    
                            <input type="text" name="lat_start" id="lat_start" class="form-control" value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['register_attentions']->lat_start : ''}}" {{ strpos(Request::url(), "create") || strpos(Request::url(), "edit") ? 'required' : '' }}>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group" >
                            {!! Form::label('long_start', 'Longitud Start:') !!}    
                            <input type="text" name="long_start" id="long_start" class="form-control" value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['register_attentions']->long_start : ''}}" {{ strpos(Request::url(), "create") || strpos(Request::url(), "edit") ? 'required' : '' }}>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {!! Form::label('end', 'End Date/Hora:') !!}
                            <input class="form-control" type="datetime-local" id="end" name="end" value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['register_attentions']->end : '' }}" {{ strpos(Request::url(), "create") || strpos(Request::url(), "edit") ? 'required' : '' }}>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group" >
                            {!! Form::label('lat_end', 'Latitud End:') !!}    
                            <input type="text" name="lat_end" id="lat_end" class="form-control" value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['register_attentions']->lat_end : ''}}" {{ strpos(Request::url(), "create") || strpos(Request::url(), "edit") ? 'required' : '' }}>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group" >
                            {!! Form::label('long_end', 'Longitud End:') !!}    
                            <input type="text" name="long_end" id="long_end" class="form-control" value="{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['register_attentions']->long_end : ''}}" {{ strpos(Request::url(), "create") || strpos(Request::url(), "edit") ? 'required' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</br>
@endif

<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {!! Form::label('note', 'Post Attention Note:') !!}
                    <textarea id="note" name="note" rows="25" class="form-control" {{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) && isset($note[0]['note']) && !empty($note[0]['note']) && Auth::user()->role_id != 1 ? 'readonly' : '' }}>{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) && isset($note[0]['note']) && !empty($note[0]['note']) ? $note[0]['note'] : '' }}</textarea>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {!! Form::label('firma', 'Signature of the Guardian:') !!}
                    <div id='view' class="abs-center" >
                        @if (isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) && isset($note[0]['firma']) && !empty($note[0]['firma']))
                            <img max-height="1000px" width="100%" src="{{ asset('filesUsers/' . $note[0]['firma']) }}">
                        @endif
                    </div>

                    </br>
                    @if (isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) && !isset($note[0]['firma']) || empty($note[0]['firma']) || Auth::user()->role_id == 1)
                        <button type="button" id="btn_modal" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Signature
                        </button>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Signature</h5>
                <button id="btn-clear-signature-x" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <canvas id="signature" style="min-height: 800px !important; max-width: 1500px !important; padding: 0 !important; margin: 0 auto !important;"></canvas>
            </div>
            <div class="modal-footer">
                <button id="btn-clear-signature" type="button" class="btn btn-secondary" data-dismiss="modal">Clear</button>
                <button id="btn-save-signature" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    @if (strpos(URL::previous(), "dashboard"))
        {!! Form::button('<a>Save</a>', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
    @else
        {!! Form::button('<a>Save</a>', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
        <a href="{{ route('notesSubServices.index') }}" class="btn btn-secondary">Cancel</a>
    @endif
</div>

@push('scripts')
<script>
function alerta(){
    var nota = $('#note').val();
    var firma = $('#firma').val();

    if(typeof nota != 'undefined' && nota != '' && nota != null && typeof firma != 'undefined' && firma != '' && firma != null){
        confirm("If you are sure, by saving you will not be able to edit the note again in the future.");
    }
}
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
            //console.log(file);
            //prps.signaturePad.clear();
            var obj = document.getElementById('btn-clear-signature-x');

            let canvas = document.getElementById('signature');
            var file = canvas.toDataURL("image/png;base64");


            var pathname = window.location.pathname;
            var idNota = pathname.split('/')[2];
            var url = '/notesSubService/' + idNota + '/update';

            var register_attentions_id = "{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['register_attentions_id'] : '' }}";
			var idUser = "{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['worker_id']['id'] : Auth::user()->id }}";
			var service_id = "{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['service_id']['id'] : '' }}";
			var patiente_id = "{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['patiente_id']['id'] : '' }}";
			var idSubService = "{{ isset($note) && !empty($note) && isset($note[0]) && !empty($note[0]) ? $note[0]['sub_service_id']['id'] : '' }}";
            var note = document.getElementById('note').value;
			var token = '{{ csrf_token() }}';
            var previa_url = document.getElementById('previa_url').value;

            if(idUser  == '', service_id == '', patiente_id == '', idSubService == ''){
                let msjOne = 'There are empty fields and you cannot proceed to the creation, please fill in all the field.\n\n';
				let msjTwo = 'Existen campos vacios y no se puede proceder a la creacion por favor llene todos los campos.';

                alert(msjOne + msjTwo);
            }else{	
                $.ajax({
                    type: "post",
                    url: url,
                    dataType: 'json',
                    data: {
                        _token: token,
                        register_attentions_id: register_attentions_id,
                        worker_id: idUser,
                        service_id: service_id,
                        patiente_id: patiente_id,
                        sub_service_id: idSubService,
                        note: note,
                        firma: file,
                        typeReturn: 'json',
                        previa_url: previa_url
                    },
                    success: function(data) {

                        if(data['userAuth'] != 1 || data['userAuth'] != '1'){                    
                            $('#btn_modal').attr("hidden", true);

                            var URLdomain = window.location.host;
                            var protocol = location.protocol;
                            var urlTotal = protocol + '//' + URLdomain + '/filesUsers/' + data['urlImagen'];

                            document.getElementById("view").innerHTML = '<img max-height="1000px" width="100%" src=' + urlTotal + '>';

                            if (obj){
                                obj.click(); 
                            }

                            if(data['prevUrl'].includes('dashboard')){
                                if(data['statusAttention'] == 3 || data['statusAttention'] == '3'){
                                    $('#note').attr('readonly', true)
                                    setTimeout(function(){
                                        window.location.href = "/dashboard";
                                    }, 1000);
                                
                                }

                                //$('#previa_url').empty()
                                //$('#previa_url').val('');
                                //$('#previa_url').val("{{ isset($prevUrl) && !empty($prevUrl) ? $prevUrl :" + localStorage.getItem('prevUrl') + "}}");
                            }else{
                                if(data['statusAttention'] == 3 || data['statusAttention'] == '3'){
                                    $('#note').attr('readonly', true)
                                    setTimeout(function(){
                                        window.location.href = "/notesSubServices";
                                    }, 1000);
                                
                                }
                            }
                        }else if(data['userAuth'] == 1 || data['userAuth'] == '1'){

                            if (obj){
                                obj.click(); 
                            }
                            setTimeout(function(){
                                window.location.reload();
                            }, 500);
                        }
                    },
                    error: function (error) { 
                        console.log(error);
                    }
                });
            }
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


@endpush