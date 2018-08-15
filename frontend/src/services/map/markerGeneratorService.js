const createMarker = () => {
    let element = document.createElement('div');
    element.style.backgroundImage = 'url("https://static.thenounproject.com/png/4096-200.png")';
    element.style.width = '200px';
    element.style.height = '200px';
    return element;
};

const createPopup = (markerData) => {
    let popup = new mapboxgl.Popup();
    popup.setHTML(`
        <div class="media">
            <div class="media-left">
                <figure class="image is-48x48">
                    <img src="${markerData.photoUrl}"/>
                </figure>
            </div>
            <div class="media-content">
                <div>
                    <strong>
                        ${markerData.name}
                    </strong>
                </div>
                <div>
                    ${markerData.address || ''}
                </div>
            </div>
        </div>
    `);
    return popup;
};

const generator = {
    generateMarker(markerData) {
        let element = createMarker();
        let marker = new mapboxgl.Marker();
        let popup = createPopup(markerData);
        marker.setPopup(popup);
        marker.setLngLat([markerData.lng, markerData.lat]);
        return marker;
    }
};

export default generator;

