@extends('template')
@section('content')     
    <div class="row inbox-wrapper">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
                <div class="p-3 pb-0">
                  <div class="to">
                    <div class="row mb-3">
                      <label class="col-md-2 col-form-label">To:</label>
                      <div class="col-md-10">
                        <select class="compose-multiple-select form-select" multiple="multiple">
                          <option value="AL">Alabama</option>
                          <option value="WY">Wyoming</option>
                          <option value="AM">America</option>
                          <option value="CA">Canada</option>
                          <option value="RU">Russia</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="to cc">
                    <div class="row mb-3">
                      <label class="col-md-2 col-form-label">Cc</label>
                      <div class="col-md-10">
                        <select class="compose-multiple-select form-select" multiple="multiple">
                          <option value="Alabama">Alabama</option>
                          <option value="Alaska" selected="selected">Alaska</option>
                          <option value="Melbourne">Melbourne</option>
                          <option value="Victoria" selected="selected">Victoria</option>
                          <option value="Newyork">Newyork</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="subject">
                    <div class="row mb-3">
                      <label class="col-md-2 col-form-label">Subject</label>
                      <div class="col-md-10">
                        <input class="form-control" type="text">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="px-3">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label visually-hidden" for="simpleMdeEditor">Descriptions </label>
                                      <textarea class="form-control" name="tinymce" id="simpleMdeEditor" rows="5"></textarea>
                    </div>
                  </div>
                  <div>
                    <div class="col-md-12">
                      <button class="btn btn-primary me-1 mb-1" type="submit"> Send</button>
                      <button class="btn btn-secondary me-1 mb-1" type="button"> Cancel</button>
                    </div>
                  </div>
                </div>
        </div>
      </div>
    </div>
    <script>
      $(function() {
  'use strict'

  if ($(".compose-multiple-select").length) {
    $(".compose-multiple-select").select2();
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2();
  }
});
    </script>
    <script>
      $(function() {
  'use strict';

  /*simplemde editor*/
  if ($("#simpleMdeEditor").length) {
    var simplemde = new SimpleMDE({
      element: $("#simpleMdeEditor")[0]
    });
  }

});
    </script>
@endsection