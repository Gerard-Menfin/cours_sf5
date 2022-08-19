let dataSrcUploadedImage = (inputElement, imgElement) => {  // version narrow function
    if (inputElement.files && inputElement.files[0]) {
       var reader = new FileReader();
       var data;
       reader.onload = function (e) {
           $(imgElement).prop("src", e.target.result);
           // ❗ fix Bootstrap File type input doesn't display name of uploaded file
           $(inputElement).next('.custom-file-label').html(inputElement.files[0].name);
       };
       reader.readAsDataURL(inputElement.files[0]);
   }
}

$(function(){
    $("[type='file']").on("change", function(){
        var id = $(this).prop("id");            // je récu)ère l'identifiant de l'input
        var label = $("[for='" + id + "']");    // le label lié à l'input à l'attribut 'for' qui vaut l'id de l'input
        label.append("<img class='mini ml-3'id='" + id + "img' >");  // j'ajoute une balise 'img'à ce label
        dataSrcUploadedImage(this, $('#' + id + 'img'));
    });
});
