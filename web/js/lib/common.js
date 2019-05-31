/*
 * Función para crear un rango de números
 */
function range(min, max, step){
  step = step || 1;
  var input = [];
  for (var i = min; i <= max; i += step) {
    input.push(i);
  }
  return input;
}

/*
 * Funciones para generar uuids
 */
function guid() {
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}

function s4() {
  return Math.floor((1 + Math.random()) * 0x10000)
    .toString(16)
    .substring(1);
}

/*
 Función para renderizar plantillas
 */
function template(id,data){
  var obj = document.getElementById(id).innerHTML;
  var temp = '';

  for (var ind in data){
    temp = '{{'+ind+'}}';
    obj = obj.replace(new RegExp(temp,"g") ,data[ind]);
  }

  return obj;
}

/*
 Función para mostrar logs por consola
*/
function doLog(str){
  if (app.getModoDebug()){
    console.log(str);
  }
}

/*
 Lista de meses y los dias que tienen
*/
var num_dias = [0,31,28,31,30,31,30,31,31,30,31,30,31];
var meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

/*
 Función equivalente al urlencode de php
*/
function urlencode( s ){
  if (s){
    return encodeURIComponent( s ).replace( /\%20/g, '+' ).replace( /!/g, '%21' ).replace( /'/g, '%27' ).replace( /\(/g, '%28' ).replace( /\)/g, '%29' ).replace( /\*/g, '%2A' ).replace( /\~/g, '%7E' );
  }
  else{
    return '';
  }
}

/*
 Función equivalente al urldecode de php
*/
function urldecode( s ){
  if (s){
    return decodeURIComponent( s.replace( /\+/g, '%20' ).replace( /\%21/g, '!' ).replace( /\%27/g, "'" ).replace( /\%28/g, '(' ).replace( /\%29/g, ')' ).replace( /\%2A/g, '*' ).replace( /\%7E/g, '~' ) );
  }
  else{
    return '';
  }
}

/*
 Función equivalente al ucfirst de php
*/
function ucfirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/*
 Función para guardar en localstorage
*/
function setLocalStorageData(key,data){
  localStorage.setItem(key, JSON.stringify(data));
}

/*
 Función para leer de localstorage y callback de error si no existe
*/
function getLocalStorageData(key,callback){
  var chk = localStorage.getItem(key);
  
  if (chk){
    return JSON.parse(chk);
  }
  else{
    return callback();
  }
}