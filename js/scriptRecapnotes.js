const btn = document.querySelector("#btnPdf");

btn.addEventListener('click', ()=>genererPdf());

function genererPdf() {
	const x = document.querySelector('#idZonePdf').innerText;
	const element = document.getElementById(x);
	var opt = {
	  margin:       [1, 0.5],
	  filename:     'recapitulatif_notes.pdf',
	  image:        { type: 'jpeg', quality: 0.98 },
	  pagebreak: { mode: 'avoid-all', before: '#page2el' },
	  jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
	};
	
	// New Promise-based usage:
	html2pdf().set(opt).from(element).save();
	
	// Old monolithic-style usage:
	//html2pdf(element, opt);
}