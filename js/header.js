let resp = (el) => {
    let prods = [];
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        console.log(prods)
        if (this.status == 200 && this.responseText) {
            prods = JSON.parse(this.responseText);
            console.log(prods.map(p => p.id_prod));
            if(prods){
                let options = "";
                prods.forEach(p => {
                    options += `<option data-value="${p.id_prod}" value="${p.denumire}"></option>`;
                });
                el.innerHTML = options;
            }
            // $(el).autocomplete({
            //     source: prods.map(p => p.denumire),
            //     select: (event, ui) => window.location.href = "./../pages/product.php?prod=" + prods.find(p => p.denumire === ui.item.value).id_prod
            // });
        }
    }
    xmlhttp.open("GET", "./../php/prodsSearchPHP.php?prods=display", true);
    xmlhttp.send();
};

