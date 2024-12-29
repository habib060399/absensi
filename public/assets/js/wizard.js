var form = $('#wizard').show();
var errors = form.find('.error').closest('section');
var getStep = errors.data('step-index');

$(function() {
  'use strict';
  form.steps({
    headerTag: "h2",
    bodyTag: "section",
    transitionEffect: "slideLeft",
      startIndex: getStep,
      onInit: function (event, currentIndex)
      {
          $('#pendidikan').on('change', function (){
              var value = $('#pendidikan option:selected').val();
              if(value == 'SMK'){
                  $('#check_jurusan').children().remove();
              }else {
                  $('#check_jurusan').html(
                      `
                        <label class="form-label">Apakah ada jurusan ?</label>
                            <select class="form-select" name="check_jurusan">
                                 <option selected disabled>Pilih</option>
                                 <option value="true">Ya</option>
                                 <option value="false">Tidak</option>
                            </select>`
                  );
              }

          });

          $('#paket').on('change', function () {
              var value = $('#paket option:selected').val()

              $.ajax({
                  url: url +"/flockbase/sekolah/paket2/"+value,
                  type: 'Get',
                  success: function (res){
                      if(res.type === 'unit'){
                          $('#count-siswa').html(
                              `<div class="mb-3">
                                    <label class="form-label">Jumlah Siswa</label>
                                    <input type="number" class="form-control" name="jml_siswa">
                                </div>`
                          );
                      }
                      $(document).ready(function() {
                          var data_paket = JSON.parse(res.detail);
                          var component = '';

                          $.each(data_paket.data, (e, i) => {
                              var feather = (i.status == 'active') ? 'check' : 'x';
                              var style = (i.status == 'active') ? 'text-primary' : 'text-danger';
                              component += `
                                            <tr>
                                                    <td><i data-feather="${feather}" class="icon-md ${style} me-2"></i></td>
                                                    <td><p>${i.text}</p></td>
                                            </tr>`;
                          });

                          $('#render-paket').html(
                              `
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="text-center mt-3 mb-4">${res.nama_paket}</h4>
                                            <i data-feather="award" class="text-primary icon-xxl d-block mx-auto my-3"></i>
                                            <h1 class="text-center">Rp. ${res.price}</h1>
                                            <p class="text-muted text-center mb-4 fw-light">per month</p>
                                            <h5 class="text-primary text-center mb-4">Up to siswa</h5>
                                            <table class="mx-auto">
                                                ${component}
                                            </table>
                                        </div>
                                    </div>
                            </div>`
                          );
                          feather.replace();
                      })
                  }
              })

          })
      },
      onFinished: function (event, currentIndex)
      {
        $('#wizard').submit();
      },
  })

});
