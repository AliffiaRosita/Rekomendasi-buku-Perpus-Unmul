function btnDelete(id,url_name,e){
    e.preventDefault();
    var url = `${url_name}/${id} `;

    Swal.fire({
    title: 'Apakah kamu yakin ingin menghapus data?',
    text: "data yang telah dihapus tidak bisa dikembalikan",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus'
    }).then((result) => {
    if (result.value) {
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data:{
                _method: "DELETE",
                id:id,
            },
            success: function(res){
                Swal.fire(
                'Data terhapus',
                res.message,
                'success'
                );
                location.reload();
            },
            error:function (xhr) {
                console.log(xhr);
                swal({
                    title : "Gagal",
                    text : "Gagal menghapus data",
                    icon : "error"
                });
            },

        });
    }
    })

    }




