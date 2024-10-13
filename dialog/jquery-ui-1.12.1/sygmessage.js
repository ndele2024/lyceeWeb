
const closeIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>`; // Thanks Google!
const fadeIn = (element, callback) => {
    let counter = 0;
    const step = 4;

    const run = () => {
        if (counter >= 100) {
            window.cancelAnimationFrame(run);

            if (callback) {
                callback(element);
            }
        } else {

            counter += step;
            element.style.opacity = (counter / 100).toString();
            window.requestAnimationFrame(run);
        }

    };

    window.requestAnimationFrame(run);
};
const fadeOut = (element, callback) => {
    let counter = 100;
    const step = 4;

    const run = () => {
        if (counter <= 0) {
            window.cancelAnimationFrame(run);

            if (callback) {
                callback(element);
            }
            
        } else {

            counter -= step;
            element.style.opacity = (counter / 100).toString();
            window.requestAnimationFrame(run);
        }

    };

    window.requestAnimationFrame(run);
};
const isString = (s) => typeof s === 'string';

const isEvent = (event) => (event.startsWith('on') ? event.toLowerCase() : `on${event}`) in window;
const h = (tag = 'div', props = null, childs = []) => {
  const el = document.createElement(tag);

  if (props !== null) {
    for (let key in props) {
      if (isEvent(key)) {
        el.addEventListener(key, (e) => {
          props[key](e, el);
        });
      } else {
        el.setAttribute(key, props[key]);
      }
    }
  }

  if (childs.length > 0) {
    childs.forEach((child) => {

      if (typeof child === 'string') {
        el.appendChild(document.createTextNode(child));
      } else {
        el.appendChild(child)
      }

    });
  }

  return el;
};
class Component {
    constructor(options) {
        this.options = options;

        if (isString(options.title)) {
            this.title = options.title;
        }

        this.useInnerHTML =  (options.useInnerHTML === true);

        if (isString(options.content)){
            this.content = options.content;
        }

        if (options.animation && (typeof options.animation === 'boolean' || isString(options.animation))) {
            this.animation = options.animation;
        } else {
            this.animation = 'fade';
        }

        this.port = null;

        this.template = this.createBase();
    }

    createBase() {
        const close = h('div', {class: 'close', click: () => {
            this.close();
        }});
        close.innerHTML = closeIcon;

        this.port = h('div', {class: 'port'});

        let style;

        if (this.animation === 'fade') {
            style = 'opacity:0;';
        } else {
            style = '';
        }

        this.container = h('div', {class: 'attention-component', style: style}, [
            h('div', {class: 'inner'}, [
                h('div', {class: 'content'}, [
                    close,
                    this.port
                ])
            ])
        ]);

        return this.container;
    }

    render(container = document.body) {
        if (this.options.beforeRender) {
            this.options.beforeRender(this);
        }

        container.appendChild(this.template);

        if (this.options.afterRender) {
            this.options.afterRender(this);
        }

        if (this.animation === 'fade') {
            fadeIn(this.template);

        }
    }

    destroy() {
        this.container.parentElement.removeChild(this.container);

        if (this.options.afterClose) {
            this.options.afterClose(this);
        }
    }

    close() {

        if (this.options.beforeClose) {
            this.options.beforeClose(this);
        }

        if (!this.animation) {
            this.destroy();
        } else if (this.animation === 'fade') {
            fadeOut(this.container, () => {
                this.destroy();
            })
        }

    }

}
class SyGPromptPass extends Component{
    constructor(options) {
        super(options);
        this.submitText = isString(options.submitText) ? options.submitText : 'Send';
        this.placeholderText = isString(options.placeholderText) ? options.placeholderText : 'Type password';
        this.injectTemplate();
        this.render();
    }
        handleInput(e, el) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            this.retourval();
        }
    }
    retourval(){
        const value = this.input.value;  
        console.log(value);
        return value;        
    }
    submit() {
        const value = this.input.value;

        if (value === '') {
            return;
        }

        this.close();

        if (this.options.onSubmit) {
            this.options.onSubmit(this, value);
        }
    }

    injectTemplate() {

        const head = h('div', {class: 'head'}, [
            h('p', {class: 'title'}, [this.title])
        ]);

        this.port.appendChild(head);

        this.input = h('input', {type: 'password', class: 'input', placeholder: this.placeholderText, keyup: (e, el) => {
            this.handleInput(e, el);
        }});

        const inputRow = h('div', {class: 'prompt-elements'}, [
            this.input,
            h('button', {class: 'button', click: () => {
                this.submit();
            }}, [this.submitText])
        ]);

        let innerContainer;

        if (this.useInnerHTML) {
          const content = h('div', {class: 'content'});
          content.innerHTML = this.content;

          innerContainer = h('div', {class: 'inner-container'}, [
            content,
            inputRow
          ]);

        } else {
          innerContainer = h('div', {class: 'inner-container'}, [
              h('p', {class: 'content'}, [this.content]),
              inputRow
          ]);
        }

        this.port.appendChild(head);
        this.port.appendChild(innerContainer);
    }
}
class SygConfirm extends Component {

    constructor(options) {
        super(options);
        this.buttonCancel = isString(options.buttonCancel) ? options.buttonCancel : 'No';
        this.buttonConfirm = isString(options.buttonConfirm) ? options.buttonConfirm : 'Agree';
        this.injectTemplate();
        this.render();
    }

    injectTemplate() {

        const head = h('div', {class: 'head'}, [
            h('p', {class: 'title'}, [this.title])
        ]);

        this.port.appendChild(head);

        let innerContainer;

        if (this.useInnerHTML) {
          const content = h('div', {class: 'content'});
          content.innerHTML = this.content;

          innerContainer = h('div', {class: 'inner-container'}, [
            content
          ]);

        } else {
          innerContainer = h('div', {class: 'inner-container'}, [
              h('p', {class: 'content'}, [this.content])
          ]);
        }

        innerContainer.appendChild(
            h('div', {class: 'buttons'}, [
                h('button', {class: 'cancel', click: () => {
                    this.close();
                    if (this.options.onCancel) {
                        this.options.onCancel(this);
                    }
                }}, [this.buttonCancel]),
                h('button', {class: 'confirm', click: () => {
                    this.close();
                    if (this.options.onConfirm) {
                        this.options.onConfirm(this);
                    }
                }}, [this.buttonConfirm])
            ])
        );

        this.port.appendChild(head);
        this.port.appendChild(innerContainer);
    }

};
//fonction noon achevé
function PromptSyg(texte,testbutsubmit,testpasswordhide){
    var sortie=null;
    new SyGPromptPass({
            title: 'SYGBUSS YAKOO',
                    content: texte,
                    submitText : testbutsubmit,
                    placeholderText: testpasswordhide,
                    onSubmit: function(component, value) {
                      // location.href='supprime_matiere1.php?passw='+value;
                      return value;
                    }
        });
}