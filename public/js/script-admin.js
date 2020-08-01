function btnDelete(id,url_name,e){
    e.preventDefault();
    var url = `${url_name}/${id} `;

    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
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
                'Deleted!',
                res.message,
                'success'
                )
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

