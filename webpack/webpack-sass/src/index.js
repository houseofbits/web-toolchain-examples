
import './style.css';
import './style.scss';
import './style.less';

function component(str, style) {

    let element = document.createElement('div');
  
    element.innerHTML = str;
    element.classList.add(style);
    
    return element;
  }
  
  document.body.appendChild(component('Hello CSS', 'hello-css'));
  document.body.appendChild(component('Hello SCSS', 'hello-scss'));
  document.body.appendChild(component('Hello LESS', 'hello-less'));