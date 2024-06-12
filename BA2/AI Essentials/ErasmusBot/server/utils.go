package main

import (
	"os"
	"strings"
)

func GetBoolEnv(key string, defaultVal ...bool) bool {
	val, ok := os.LookupEnv(key)
	if !ok && len(defaultVal) > 0 {
		return defaultVal[0]
	}
	val = strings.ToLower(val)
	return val == "true" || val == "t" || val == "1"
}
