package config

func assert(cond bool, msg ...string) {
	if cond {
		return
	}
	if len(msg) > 0 {
		panic(msg[0])
	}
	panic("assertion failed")
}
