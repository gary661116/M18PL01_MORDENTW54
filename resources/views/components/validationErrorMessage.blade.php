<!-- 檔案位置：resources/views/components/validationErrorMessage.blade.php -->
@if($errors AND count($errors))
    <div class="alert alert-warning" role="alert">
        <ul>
            @foreach($errors->all() as $err)
                <li> <font color="red">{{ $err }}</font> </li>
            @endforeach
        </ul>
    </div>
@endif