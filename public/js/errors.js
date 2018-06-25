function getErrorMessage(error) {
    switch (error) {
        case 'badData':
            return 'A informação é inválida.'
        case 'badImage':
            return 'A imagem é inválida.'
        case 'imageTooLarge':
            return 'A imagem é demasiada pesada.'
        case 'moveFailed':
            return 'Não foi possível guardar a imagem.'
        case 'invalidDate':
            return 'A data é inválida.'
        case 'dbError':
            return 'Ocorreu um erro de base de dados.'
        case 'badClient':
        case 'badAdmin':
            return 'A conta não existe.'
        case 'userAlreadyExists':
            return 'Esta conta já existe.'
    }

    return 'Ocorreu um erro desconhecido.'
}