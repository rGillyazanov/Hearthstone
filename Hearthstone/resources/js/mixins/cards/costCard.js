export default {
    methods: {
        getCostCard(rarity_id) {
            switch (rarity_id) {
                case 1:
                    return  50;
                case 2:
                    return 100;
                case 3:
                    return  400;
                case 4:
                    return  1600;
                default:
                    return 0;
            }
        }
    }
}