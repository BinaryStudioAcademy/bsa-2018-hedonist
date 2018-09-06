const bgImage = require('@/assets/marker.png');

const createMarker = () => {
    let element = document.createElement('div');
    element.style.backgroundImage = bgImage;
    element.style.width = '200px';
    element.style.height = '200px';

    return element;
};

const createPopup = (markerData) => {
    let popup = new mapboxgl.Popup();
    popup.setHTML(`
        <div class="media">
            <div class="media-left">
                <figure class="image is-64x64">
                    <img src="${markerData.photoUrl}"/>
                </figure>
            </div>
            <div class="media-content">
                <div>
                    <a class="link-place has-text-black is-size-6" href="/places/${markerData.id}" target="_blank">
                        <strong>
                            ${markerData.name}
                        </strong>
                    </a> 
                </div>
                <div>
                    ${markerData.category || ''}
                </div>
                <div>
                    ${markerData.address || ''}
                </div>
            </div>
        </div>
    `);

    return popup;
};

const createSmallPopup = (markerData) => {
    let popup = new mapboxgl.Popup();
    popup.setHTML(`
        <div class="small-marker-wrapper">
                <div>
                    <a class="link-place has-text-black is-size-6" href="/places/${markerData.id}" target="_blank">
                        <strong>
                            ${markerData.name}
                        </strong>
                    </a> 
                </div>
                <div>
                    ${markerData.category || ''}
                </div>
                <div>
                    ${markerData.address || ''}
                </div>
        </div>
    `);

    return popup;
};

const generate = (markerData) => {
    let element = createMarker();
    let marker = new mapboxgl.Marker();
    let popup = createPopup(markerData);
    marker.setPopup(popup);
    marker.setLngLat([markerData.lng, markerData.lat]);
    return marker;
};

const generateSmallMarker = (markerData) => {
    let element = createMarker();
    let marker = new mapboxgl.Marker();
    let popup = createSmallPopup(markerData);
    marker.setPopup(popup);
    marker.setLngLat([markerData.lng, markerData.lat]);
    return marker;
};

export default {generateDefaultMarker: generate, generateSmallMarker};

