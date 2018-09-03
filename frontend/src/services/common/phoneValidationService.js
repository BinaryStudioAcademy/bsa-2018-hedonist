const E164 = /^\+\d+$/;

const digits = /^\d+$/;

const isDigits = (phone) => (phone.length >= 10 && phone.length <= 16 && digits.test(phone));

const isE164 = (phone) => (phone.length >= 11 && phone.length <= 17 && E164.test(phone));

const phoneSymbols = ['0','1','2','3','4','5','6','7','8','9','+','F5','Tab','Backspace','Delete'];

const isPhone = (phone) => isDigits(phone) || isE164(phone) || phone == null;

const isValidPhoneCharacter = (character) => phoneSymbols.includes('' + character);

export default {isPhone, isValidPhoneCharacter};