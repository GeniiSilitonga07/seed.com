function loadFruit(increase){
	const seq = getNextFruitSeq(increase);
	const url = "json/" + seq + ".json";
	console.log("url " + url);
	$.ajax({
		"url": url,
		success: function(data){
			renderFruit(data);
		}
	});
} 

 function renderFruit(data){
 	console.log(JSON.stringify(data));
 	$("#picture").attr("src", data.image);
 	$("#name").text(data.name);
 	$("#latin").text(data.latin);
 	$("#color").text(data.color);
 } 

 function getNextFruitSeq(increase){
 	if(increase){
 		++fruitSeq;
 	} else {
 		--fruitSeq;
 	}
 	if(fruitSeq > 4){
 		fruitSeq = 1;
 	}
 	if(fruitSeq == 0){
 		fruitSeq = 4;
 	}
 	return(fruitSeq);
 }