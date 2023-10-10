package org.paumard.lambdamasterclass.part1.util;

import java.util.function.Predicate;
import java.util.function.Supplier;

public interface Validator<T> {

    class ValidationException extends RuntimeException {
        public ValidationException(String message) {
            super(message);
        }
    }

    Supplier<T> validate(T t);

    default Validator<T> thenValidate(Predicate<T> predicate, String error) {
        return t -> () -> {
           validate(t).get();
           if (predicate.test(t)) {
               throw new ValidationException("The object is invalid: " + error);
           } else {
               return t;
           }
        };
    }

     static <T> Validator<T> firstValidate(Predicate<T> predicate, String error) {
        return t -> predicate.test(t) ? () -> {
            throw new ValidationException("The object is invalid: " + error);
        } : () -> t;
    }

}
