<?php
/**
 * Plugin Name:     Product search feature
 * Plugin URI:      https://leefun.us/
 * Description:     MDT search feature
 * Author:          Leefun
 * Author URI:      https://leefun.us/
 * Text Domain:     Search product
 * Domain Path:     /languages
 * Version:         0.0.1
 *
 * @package         Search product
 */

add_action( 'leefun_mdt_ajax_search', 'mdt_ajax_search' );
function mdt_ajax_search() {

	if (is_page('List of Available Tubes') || is_page('Liste des tubes disponibles') ) {
	?>
	
	<br><center><input type="text" id="searchTerm" name="searchTerm" onInput="searchMDT(event)"></center>

	<script type="text/javascript">
		
		const alphabets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');

		const searchMDT = (e) => {
			const searchTerm = event.target.value;
			const resultArea = document.querySelector(".items-inner");

			if (searchTerm.length > 0) {
				const searchResult = [...window.mdts].filter((item) => item.outerText.toLowerCase().includes(searchTerm.toLowerCase()) );
	
				if (searchResult.length > 0) {
	
					const newChild = document.createElement("div");
					for (let i = 0; i < searchResult.length; i++) {
						newChild.appendChild(searchResult[i]);
					}
					resultArea.replaceChildren(newChild);
				} else {
					const notFound = document.createTextNode("No products were found matching your selection.");
					resultArea.replaceChildren(notFound);
				}

			} else if ((searchTerm.length == 0)) {
				document.querySelector(".items-outer").replaceChildren(window.originalDOM);
				globalThis.originalDOM = document.querySelector(".items-inner").cloneNode(true);
				defaultView();
				handleClickOnAlphabet();
			}
		}

		const defaultView = () => {
			for (let i = 0; i < alphabets.length; i++) {
				try {
					const elem = document.getElementById(`a-z-listing-letter-${alphabets[i]}-1`);
					elem.style.display = 'none';
				}
				catch(err) {
				}
			}

			const elem = document.getElementById(`a-z-listing-letter-A-1`);
			elem.style.display = 'block';
		}

		const handleClickOnAlphabet = () => {

			for (let i = 0; i < alphabets.length; i++) {
				try {
					const elemList = document.getElementById(`a-z-listing-letter-${alphabets[i]}-1`);
					
					window.elemAlpha[i].onclick = () => {
						defaultView();
						const elem = document.getElementById(`a-z-listing-letter-A-1`);
						elem.style.display = 'none';

						elemList.style.display = 'block'
					}
				}
				catch(err) {
				}
			}
		}

		const hideHref = (a) => {
			a.href = "#mdt-search"
		}

		document.addEventListener('DOMContentLoaded', () => {  

			globalThis.mdts = document.querySelectorAll(".letter-section li");
			globalThis.originalDOM = document.querySelector(".items-inner").cloneNode(true);
			globalThis.elemAlpha = document.querySelectorAll("li[class*='-posts']");
			document.querySelectorAll("a[href*='#a-z-listing-letter']").forEach(hideHref);

			defaultView();
			handleClickOnAlphabet();

		});

		setTimeout(() => {
			
			product_title_selectors = [
				'div.letter-section a'
			]
	
			product_title_selectors.forEach(selector => {
				const product_titles = document.querySelectorAll(selector);
				if (product_titles.length > 0) {
	
					product_titles.forEach(title => {
						if (!title.innerHTML.includes('®')) {
							title.innerHTML = title.innerHTML.concat('®');
						}
						title.innerHTML = title.innerHTML.replace(/[™®©]/g, '<sup>$&</sup>');
					})
	
				}
	
			})
		}, 100);


	</script>
	
	<?php
	}
}