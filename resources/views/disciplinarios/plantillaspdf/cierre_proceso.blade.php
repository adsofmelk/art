@extends('disciplinarios.plantillaspdf._template_documento')

@section('contenido')
<div style='margin-top: 120px;'>
<p>Bogotá D.C., {{$dia}} de {{$mes}} de {{$anio}}</p>
<p>Señor (a)<br>
<strong>{{$nombre}}</strong>
<br>Ciudad</p>

<p>E. S. M.</p>
<p style='text-align:right;'><strong>Ref. Respuesta a su carta de renuncia.</strong></p>
<p>Respetado (a) Señor (a):</p>
<p>Por medio de la presente, acusamos de recibo su comunicación, manifestándole que la empresa acepta su renuncia voluntaria, libre y espontanea, la cual se hace efectiva al finalizar la jornada laboral del día {{$diarenuncia}} de {{$mesrenuncia}} de {{$aniorenuncia}}. Sin prejuicio de lo anterior, mediante este documento, nos permitimos informarle que las razones por las cuales usted sustenta su decisión de renuncia, no son aceptadas por la empresa , en tanto que resultan improcedentes. Por lo anterior, le solicito hacer la devolución de los elementos entregados para el desempeño de su cargo; para tales efectos es indispensable diligenciar el paz y salvo, el cual debe ser firmado por quien recibe de parte de BRM.
<br>Igualmente, en este mismo documento podrá solicitar la orden de examen médico, si no lo hace, y/o pasados cinco días hábiles de su retiro Ud. no efectúa el examen, la Compañia dará por entendido que no está interesado en efectuárselo. La liquidación y demás acreencias laborales a que tiene derecho le serán reconocidas en un término prudencial, tal como se pactó en el contrato laboral y abonadas a su cuenta nominal a menos que Ud. informe antes del pago una cuenta diferente que se encuentre a su nombre.</p>

<p>Sin otro particular, cordialmente.</p>
<div style='margin-top: 40px;'>
<p>Atentamente,<br>
Gerencia de Relaciones Laborales</p>
</div>
</div>

@endsection