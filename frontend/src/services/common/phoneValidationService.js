const isDigits = (phone) => phone.length >= 10 && phone.length <= 16 && phone.match('/\d+/');

const isE164 = (phone) => phone.length >= 11 && phone.length <= 17 && phone.match('/\+\d+/');

const isNANP = (phone) => phone.match('/^(?:\\+1|1)?\\s?-?\\(?\\d{3}\\)?(\\s|-)?\\d{3}-\\d{4}$/i');

const isPhone = (phone) => isDigits(phone) || isE164(phone) || isNANP(phone);

const isValidPhoneCharacter = (character) => character.match('/[\d+-]/');

export default {isPhone, isValidPhoneCharacter};