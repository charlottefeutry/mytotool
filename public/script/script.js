
$(document).ready(function() {

    //ajouter liste
    $('#saveCreateList').click(function (){
        var nom = $('#createList').val();
        if (nom !== '') {
            $.ajax({
                url: '/list',
                type: 'POST',
                data: {nom: nom},
                success: function (data){
                    $('#listMenu').append(`<li class="list-group-item d-flex justify-content-between align-items-center list-group-item:last-child"> <a href=""> ${nom} </a>
                        <span class="badge rounded-pill"> 14</span></li></a>
                    <button type="submit" class="supprimerliste" data-listId="{{ listeTaches.id }}">Supprimer la liste</button>`);



                    $('#closeModal').click();
                }
            });
        }
    });

//ajouter tache
    $('#saveCreateTask').click(function (){
        var nom = $('#createTask').val();
        if (nom !== '')
        var listId = $(this).attr('data-listId');
            {
            $.ajax({
                url: '/task',
                type: 'POST',
                data: {nom: nom, listId: listId},
                success: function (data){
                    $('#listTask').append(`
                            <div class="input-group mb-3" id="${data.id}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                                <input type="text" class="form-control " aria-label="Text input with checkbox" 
                                value="${nom}" disabled>
                            </div>`);
                    $('#closeModal2').click();
                }
            });
        }
    });



//afficher les taches dans les listes
    $('#saveCreateTache').click(function (){
        var nom = $('#createTache').val();
        if (nom !== '') {
            $.ajax({
                url: '/list',
                type: 'POST',
                data: {nom: nom},
                success: function (data){
                    $('#listMenu').append(`<li class="list-group-item d-flex justify-content-between align-items-center list-group-item:last-child">  
                    4<a href="">${nom} </a></li>`);
                    $('#closeModal').click();
                }
            });
        }
    });
});

//suppression on click checkbox
$('.checkboxTache').click(function (){

    var tacheId = $(this).attr('data-tacheId');
    $.ajax({
            url: `/task/${tacheId}`,
            type: 'DELETE',
            success: function (){
                $(`#li-${tacheId}`).remove()
            }
        });
    }
)

//supprimer liste
$(document).ready(function() {
    $('.supprimerliste').click(function (e) {
        let listId = $(this).attr('data-listId')
        if (listId !== '') {
            $.ajax({
                url: '/list',
                type: "DELETE",
                data: {listId: listId},
                success: function (data) {
                    $(location).attr('href', '/');

                }
            })
        }
    })
})
