@if($model->hasPages())
    <footer class="container">{{ $model->links() }}</footer>
@endif