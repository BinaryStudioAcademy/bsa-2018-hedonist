const alpha = /^[a-zA-Z]*$/;
const isAlpha = (userName) => (alpha.test(userName));

const alphaCyrillic = /^[\u0400-\u04FF]*$/;
const isAlphaCyrillic = (userName) => (alphaCyrillic.test(userName));

const isUserName = (userName) => isAlpha(userName) || isAlphaCyrillic(userName); 

export default {isUserName,isAlpha,isAlphaCyrillic};
