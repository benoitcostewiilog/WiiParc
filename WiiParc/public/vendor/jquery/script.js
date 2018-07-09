/**
 * Script jQuery
 */

$(document).ready(function() { 

	console.log( "ready!" );

	/**
 	* Permet de cliquer sur une ligne du tableau "Accueil"
 	* Rediriger vers la Vue correspondante
 	*/

	$('tbody').on("click", "tr", function() {
		var nparc = $(this).find('td').eq(0).html();
		var pathArray = window.location.pathname.split("/");
		var url =  window.location.protocol + "//" + window.location.host;
		for (var i = 0; i < pathArray.length - 2; i++) {
			url += pathArray[i] + "/";
		}
		window.location.assign(url + "parc/vue/" + nparc);
	});

	/**
	 * Dynamic search
	 */

	$(".form-control").on("keyup", function() {
	  var value = $(this).val().toLowerCase();
	  $("tbody tr").filter(function() {
	    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	  });
	});

	/**
	 * Tri de tableau
	 */
	function twInitTableau() {
			[].forEach.call( document.getElementsByClassName("avectri"), function(oTableau) {
				var oEntete = oTableau.getElementsByTagName("tr")[0];
				var nI = 1;
				[].forEach.call( oEntete.querySelectorAll("th"), function(oTh) {
					oTh.addEventListener("click", twTriTableau, false);
					oTh.setAttribute("data-pos", nI);
					if(oTh.getAttribute("data-tri") == "1") {
						oTh.innerHTML += "<span class=\"flecheDesc\"></span>";
					} else {
						oTh.setAttribute("data-tri", "0");
						oTh.innerHTML += "<span class=\"flecheAsc\"></span>";
					}
					// Tri par défaut
					if (oTh.className == "selection") {
						oTh.click();
					}
					nI++;
				});
			});
	}
	
  function twInit() {
	twInitTableau();
  }

	function twPret(maFonction) {
		if (document.readyState != "loading"){
			maFonction();
		} else {
			document.addEventListener("DOMContentLoaded", maFonction);
		}
	}
	
  twPret(twInit);
			
	function twTriTableau() {
		var nBoolDir = this.getAttribute("data-tri");
		this.setAttribute("data-tri", (nBoolDir=="0") ? "1" : "0");
		[].forEach.call( this.parentNode.querySelectorAll("th"), function(oTh) {
			oTh.classList.remove("selection");
			oTh.classList.add("align-middle");
		});
		this.className = "selection align-middle";
		this.querySelector("span").className = (nBoolDir == "0") ? "flecheAsc" : "flecheDesc";

		var oTbody = this.parentNode.parentNode.parentNode.getElementsByTagName("tbody")[0]; 
		var oLigne = oTbody.rows;
		var nNbrLigne = oLigne.length;
		var aColonne = new Array(), i, j, oCel;
		for(i = 0; i < nNbrLigne; i++) {
			oCel = oLigne[i].cells;
			aColonne[i] = new Array();
			for(j = 0; j < oCel.length; j++) {
				aColonne[i][j] = oCel[j].innerHTML;
			}
		}
			
		var nIndex = this.getAttribute("data-pos");
		var sFonctionTri = (this.getAttribute("data-type") == "num") ? "compareNombres" : "compareLocale";
		aColonne.sort(eval(sFonctionTri));
		function compareNombres(a, b) {return a[nIndex-1] - b[nIndex-1];}
		function compareLocale(a, b) {return a[nIndex-1].localeCompare(b[nIndex-1]);}
		if (nBoolDir == 0) aColonne.reverse();
		
		// Construit les colonne du nouveau tableau
		for(i = 0; i < nNbrLigne; i++){
			aColonne[i] = "<td>" + aColonne[i].join("</td><td>") + "</td>";
		}
		oTbody.innerHTML = "<tr>" + aColonne.join("</tr><tr>") + "</tr>";
	}

});
