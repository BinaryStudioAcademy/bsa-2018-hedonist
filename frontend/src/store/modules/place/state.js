export default {
    places: [
        {
            id: 1,
            name: "Spa resort",
            rating: 9.8,
            address: "Sample address",
            category: "Sample category",
            city: 'Kyiv',
            phone: '+380 44 287 4436',
            website: 'http://mamamanana.kiev.ua/',
            photo: {url: "http://via.placeholder.com/200x200"},
            tags: [{id: 1, name: 'Tag1'}, {id: 2, name: 'Tag2'}],
            longitude:0,
            latitude:0,
            reviews: [
                {
                    id: 1,
                    user: {
                        name: 'Sample User1',
                        avatar: 'https://randomuser.me/api/portraits/men/1.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                    likes: '1.5k',
                    dislikes: '100'
                },
                {
                    id: 2,
                    user: {
                        name: 'Sample User2',
                        avatar: 'https://randomuser.me/api/portraits/men/2.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                    likes: '1.5k',
                    dislikes: '100'
                }
            ]
        },
        {
            id: 2,
            name: "Kino planet",
            rating: 10,
            address: "Sample address",
            category: "Sample category",
            city: 'Lviv',
            phone: '+380 66 123 4488',
            website: 'http://beef.kiev.ua',
            photo: {url: "http://via.placeholder.com/200x200"},
            tags: [{id: 1, name: 'Tag3'}, {id: 2, name: 'Tag4'}],
            longitude:1,
            latitude:1,
            reviews: [
                {
                    id: 3,
                    user: {
                        name: 'Sample User3',
                        avatar: 'https://randomuser.me/api/portraits/men/3.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                    likes: '1.5k',
                    dislikes: '100'
                },
                {
                    id: 4,
                    user: {
                        name: 'Sample User4',
                        avatar: 'https://randomuser.me/api/portraits/men/4.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                    likes: '1.5k',
                    dislikes: '100'
                }
            ]
        },
        {
            id: 3,
            name: "Albatross",
            rating: 8,
            address: "Sample address",
            category: "Sample category",
            city: 'Chernihiv',
            phone: '+380 96 332 4437',
            website: 'http://php.net',
            photo: {url: "http://via.placeholder.com/200x200"},
            tags: [{id: 1, name: 'Tag5'}, {id: 2, name: 'Tag6'}],
            longitude:2,
            latitude:2,
            reviews: [
                {
                    id: 5,
                    user: {
                        name: 'Sample User5',
                        avatar: 'https://randomuser.me/api/portraits/men/5.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                    likes: '1.5k',
                    dislikes: '100'
                },
                {
                    id: 6,
                    user: {
                        name: 'Sample User6',
                        avatar: 'https://randomuser.me/api/portraits/men/6.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consectetur aliquet est. In scelerisque maximus tincidunt. Nam eleifend, diam ac vehicula aliquam, eros libero ornare metus, nec congue risus dolor sed nisl.',
                    likes: '1.5k',
                    dislikes: '100'
                }
            ]
        }
    ]
};
