export default {
    places: [
        {
            id: 1,
            name: 'Spa resort',
            rating: 9.8,
            address: 'Bohdana Khmel\'nyts\'koho Street, 31/27',
            category: 'Hotels',
            city: 'Kyiv',
            phone: '+380 44 287 4436',
            website: 'http://mamamanana.kiev.ua/',
            photo: {url: 'http://via.placeholder.com/200x200'},
            tags: [{id: 1, name: 'sleep'}, {id: 2, name: 'house'}],
            reviews: [
                {
                    id: 1,
                    user: {
                        name: 'Ivan Rottenberg',
                        avatar: 'https://randomuser.me/api/portraits/men/1.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'So vast, so many paths to choose from, so many activities to do. Ideal for jogging, cycling and merely walking. Also great picnic spots all around.',
                    likes: '1.5k',
                    dislikes: '100'
                },
                {
                    id: 2,
                    user: {
                        name: 'Liza Yroboros',
                        avatar: 'https://randomuser.me/api/portraits/men/2.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'The most expensive afternoon tea I have ever had! Nonetheless the scones together with their special jam are heavenly tasty. Friendly staff, and you can enjoy live music...',
                    likes: '1.5k',
                    dislikes: '100'
                }
            ]
        },
        {
            id: 2,
            name: 'Kino planet',
            rating: 10,
            address: 'York Street, 21',
            category: 'Cinemas',
            city: 'Lviv',
            phone: '+380 66 123 4488',
            website: 'http://beef.kiev.ua',
            photo: {url: 'http://via.placeholder.com/200x200'},
            tags: [{id: 1, name: 'films'}, {id: 2, name: 'Star Wars'}],
            reviews: [
                {
                    id: 3,
                    user: {
                        name: 'Galina Kopchikina',
                        avatar: 'https://randomuser.me/api/portraits/men/3.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'Get popcorn and dump the chocolate coated honeycomb bites into it. Also the honey roasted cashews are amazing.',
                    likes: '1.5k',
                    dislikes: '100'
                },
                {
                    id: 4,
                    user: {
                        name: 'Mika Newton',
                        avatar: 'https://randomuser.me/api/portraits/men/4.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'This is one of my favourite cinemas, comfortable, spacious seats, and because its not the big it\'s cosier! And the staff are lovely and funny!',
                    likes: '1.5k',
                    dislikes: '100'
                }
            ]
        },
        {
            id: 3,
            name: 'Albatross',
            rating: 8,
            address: 'Park Avenue, 66',
            category: 'Restaurants',
            city: 'Chernihiv',
            phone: '+380 96 332 4437',
            website: 'http://php.net',
            photo: {url: 'http://via.placeholder.com/200x200'},
            tags: [{id: 1, name: 'food'}, {id: 2, name: 'drink'}],
            reviews: [
                {
                    id: 5,
                    user: {
                        name: 'Gosha Kycenko',
                        avatar: 'https://randomuser.me/api/portraits/men/5.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'My favourite pizza ever, if they have spinach in stock that\'s the best, otherwise the number 6 with chorizo works a charm. A good sized pizza for one person.',
                    likes: '1.5k',
                    dislikes: '100'
                },
                {
                    id: 6,
                    user: {
                        name: 'Grigory Leps',
                        avatar: 'https://randomuser.me/api/portraits/men/6.jpg'
                    },
                    published_at: '2018-08-08',
                    text: 'Very good restaurant by the main lake. Good food ( organic mainly) and good atmosphere. Service was good and staff are friendly.',
                    likes: '1.5k',
                    dislikes: '100'
                }
            ]
        }
    ]
};
