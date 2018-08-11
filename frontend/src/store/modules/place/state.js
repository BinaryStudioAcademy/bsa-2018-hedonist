export default {
    places: [
        {
            id: 1,
            name: "Spa resort",
            rating: 9.8,
            address: "Sample address",
            category: "Sample category",
            photo: {url: "http://via.placeholder.com/200x200"},
            tags: [{id: 1, name: 'Tag1'}, {id: 2, name: 'Tag2'}],
            review: {
                user: {
                    name: 'Sample User',
                    avatar: 'http://stylus-lang.com/img/octocat.svg'
                },
                published_at: '2018-08-08',
                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                likes: '1.5k',
                dislikes: '100'
            }
        },
        {
            id: 2,
            name: "Kino planet",
            rating: 10,
            address: "Sample address",
            category: "Sample category",
            photo: {url: "http://via.placeholder.com/200x200"},
            tags: [{id: 1, name: 'Tag1'}, {id: 2, name: 'Tag2'}],
            review: {
                user: {
                    name: 'Sample User',
                    avatar: 'http://stylus-lang.com/img/octocat.svg'
                },
                published_at: '2018-08-08',
                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                likes: '1.5k',
                dislikes: '100'
            }
        },
        {
            id: 3,
            name: "Albatross",
            rating: 8,
            address: "Sample address",
            category: "Sample category",
            photo: {url: "http://via.placeholder.com/200x200"},
            tags: [{id: 1, name: 'Tag1'}, {id: 2, name: 'Tag2'}],
            review: {
                user: {
                    name: 'Sample User',
                    avatar: 'http://stylus-lang.com/img/octocat.svg'
                },
                published_at: '2018-08-08',
                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                likes: '1.5k',
                dislikes: '100'
            }
        }
    ],
    truePlaces: null,
    currentPlace: null
};
