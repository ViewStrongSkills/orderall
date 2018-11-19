<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            if (fileName) {
              $('#choose-filename').text(fileName);
            }
            else {
              $('#choose-filename').text('Choose File');
            }
        });
    });
</script>
<div class="field image-upload {{ ($errors->has($name) ? 'has-error' : null) }}">
  @if ($label)
    <label for="field-{{ $name }}">{{ $label }}</label>
  @endif
  @if($file && !$errors->has($name))
    <label id="file-choose-label" class="btn btn-default btn-file" style="display:none;" >
      <span id="choose-filename">Choose File</span>{{ Form::file($name, ['id' => 'field-' . $name, 'style' => 'display:none;']) }}
    </label>
    <a href="#" class="change-image btn btn-default" style="width:100%;" onclick="$('#file-choose-label').css('display', 'block');$('#edit-image-preview').hide();$(this).hide();$('#hidden-file-input').attr({'value': ''});">Change</a>
    <br />
    <input id="hidden-file-input" type="hidden" name="{{ $name }}" value="{{ $file }}">
    <img id="edit-image-preview" src="{{Storage::url($file)}}" width="100%">
  @else
    <br>
    <label class="btn btn-default btn-file" style="width:100%;">
      <span id="choose-filename">Choose File</span>{{ Form::file($name, ['id' => 'field-' . $name, 'style' => 'display:none;']) }}
    </label>
  @endif
</div>
