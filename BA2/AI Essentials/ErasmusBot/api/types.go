package api

import "context"

type ErasmusBot interface {
	SetCtx(ctx context.Context)
}
