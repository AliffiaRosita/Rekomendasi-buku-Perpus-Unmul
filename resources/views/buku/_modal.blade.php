<div class="modal fade modal-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">
                      {{$book->judul}}
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
              </div>
              <div class="modal-body">
                <img src="{{asset("/image/buku/".$book->foto)}}"  class="img-thumbnail" alt="">
                <div class="row mt-3">
                    <div class="col-4">
                        <h5>Penerbit</h5>
                        <p>{{$book->penerbit}}</p>
                    </div>
                    <div class="col-6">
                            <h6>ISBN (International Standard Book Number)</h6>
                            <p>{{$book->isbn}}</p>
                    </div>
                </div>
                <h5 class="mt-3">Deskripsi</h5>
                <p>{{$book->deskripsi}}</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
          </div>
        </div>
      </div>
