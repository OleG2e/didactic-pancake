@if($model->replies()->hasPages())
    <footer class="container">{{ $model->replies()->links() }}</footer>
@endif