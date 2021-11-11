export default function () {
  const component = d.getAll('.offices__tab');

  const toggles = [];
  const contents = [];
  const map = [];


  for (let i = 0; i < component.length; i++) {

    toggles.push(d.getAll({'.offices__tab-item': component[i]}));
    contents.push(d.getAll({'.offices__content-item': component[i]}));
    map.push(d.getAll({'.offices__map-item': component[i]}));

    toggles[0][0].classList.add('offices__tab-item--active');
    contents[0][0].classList.add('offices__content-item--active');
    map[0][0].classList.add('offices__map-item--active');

    //On tab header click
    for (let j = 0; j < toggles[i].length; j++) {

      d.on('click', toggles[i][j], function () {

        //Close all tabs inside component
        for (let k = 0; k < toggles[i].length; k++) {
          toggles[i][k].classList.remove('offices__tab-item--active');
          contents[i][k].classList.remove('offices__content-item--active');
          map[i][k].classList.remove('offices__map-item--active');
        }

        //Show clicked tab
        toggles[i][j].classList.add('offices__tab-item--active');
        contents[i][j].classList.add('offices__content-item--active');
        map[i][j].classList.add('offices__map-item--active');
      })
    }
  }
}